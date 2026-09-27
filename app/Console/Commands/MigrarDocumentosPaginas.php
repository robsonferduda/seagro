<?php

namespace App\Console\Commands;

use App\Models\Pagina;
use App\Models\PaginaDocumento;
use Carbon\Carbon;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MigrarDocumentosPaginas extends Command
{
    protected $signature = 'paginas:migrar-documentos
                            {--paginas=12,13,14 : IDs das páginas, separados por vírgula}
                            {--dry-run : Apenas mostra o que seria feito, sem gravar nada}';

    protected $description = 'Converte as listas de arquivos em HTML (forum-item) das páginas em registros de pagina_documento';

    private const HOSTS_PROPRIOS = ['seagro-sc.org.br', 'www.seagro-sc.org.br'];

    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');
        $ids = array_filter(array_map('intval', explode(',', (string) $this->option('paginas'))));

        if ($dryRun) {
            $this->warn('Modo simulação (--dry-run): nada será gravado.');
        }

        foreach ($ids as $id) {
            $pagina = Pagina::find($id);
            if (!$pagina) {
                $this->error("Página {$id} não encontrada.");
                continue;
            }

            $this->line('');
            $this->info("Página {$pagina->id} - {$pagina->apelido}");

            if ($pagina->documentos()->exists()) {
                $this->comment('  Já possui documentos cadastrados; ignorada.');
                continue;
            }

            [$documentos, $textoRestante] = $this->extrair((string) $pagina->text);

            if (!count($documentos)) {
                $this->comment('  Nenhum forum-item encontrado; ignorada.');
                continue;
            }

            $linhas = [];
            foreach ($documentos as $doc) {
                $local = !preg_match('#^https?://#i', $doc['arquivo']);
                $existe = $local ? file_exists(public_path($doc['arquivo'])) : null;
                $linhas[] = [
                    $doc['nu_ordem'],
                    $doc['dt_publicacao'] ? $doc['dt_publicacao']->format('d/m/Y') : '-',
                    mb_strimwidth($doc['titulo'], 0, 60, '...'),
                    $doc['arquivo'],
                    $local ? ($existe ? 'ok' : 'NÃO ENCONTRADO') : 'externo',
                ];
            }
            $this->table(['Ordem', 'Data', 'Título', 'Arquivo', 'Local'], $linhas);
            $this->line('  Texto restante na página: ' . ($textoRestante === '' ? '(vazio)' : strlen($textoRestante) . ' caracteres'));

            if ($dryRun) {
                continue;
            }

            $backup = 'backup_paginas/pagina_' . $pagina->id . '_' . date('Ymd_His') . '.html';
            Storage::disk('local')->put($backup, (string) $pagina->text);

            DB::connection('mysql')->transaction(function () use ($pagina, $documentos, $textoRestante) {
                foreach ($documentos as $doc) {
                    PaginaDocumento::create([
                        'id_pagina'     => $pagina->id,
                        'titulo'        => $doc['titulo'],
                        'subtitulo'     => $doc['subtitulo'] ?: null,
                        'arquivo'       => $doc['arquivo'],
                        'dt_publicacao' => $doc['dt_publicacao'],
                        'nu_ordem'      => $doc['nu_ordem'],
                        'fl_ativo'      => 1,
                    ]);
                }

                $pagina->text = $textoRestante;
                $pagina->save();
            });

            $this->info('  ' . count($documentos) . ' documento(s) migrado(s). Backup do HTML original: storage/app/' . $backup);
        }

        return 0;
    }

    /**
     * @return array{0: array<int, array>, 1: string} documentos extraídos e HTML da página sem os blocos forum-container
     */
    private function extrair(string $html): array
    {
        if (trim($html) === '') {
            return [[], $html];
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8"?><html><body><div id="__raiz">' . $html . '</div></body></html>');
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $raiz = $dom->getElementById('__raiz') ?: $xpath->query('//div[@id="__raiz"]')->item(0);

        $documentos = [];
        $ordem = 0;
        foreach ($xpath->query('.//div[' . $this->temClasse('forum-item') . ']', $raiz) as $item) {
            $link = $xpath->query('.//a[' . $this->temClasse('forum-item-title') . ']', $item)->item(0);
            if (!$link instanceof DOMElement) {
                continue;
            }

            $sub = $xpath->query('.//*[' . $this->temClasse('forum-sub-title') . ']', $item)->item(0);
            $data = $xpath->query('.//*[' . $this->temClasse('views-number') . ']', $item)->item(0);

            $documentos[] = [
                'titulo'        => $this->texto($link->textContent),
                'subtitulo'     => $sub ? $this->texto($sub->textContent) : '',
                'arquivo'       => $this->normalizarLink($link->getAttribute('href')),
                'dt_publicacao' => $data ? $this->parseData($this->texto($data->textContent)) : null,
                'nu_ordem'      => $ordem++,
            ];
        }

        if (!count($documentos)) {
            return [[], $html];
        }

        foreach (iterator_to_array($xpath->query('.//div[' . $this->temClasse('forum-container') . ']', $raiz)) as $container) {
            $container->parentNode->removeChild($container);
        }

        $restante = '';
        foreach ($raiz->childNodes as $filho) {
            $restante .= $dom->saveHTML($filho);
        }

        return [$documentos, trim(strip_tags($restante, '<img><iframe>')) === '' ? '' : trim($restante)];
    }

    private function temClasse(string $classe): string
    {
        return "contains(concat(' ', normalize-space(@class), ' '), ' {$classe} ')";
    }

    private function texto(string $valor): string
    {
        return trim(preg_replace('/\s+/u', ' ', $valor));
    }

    private function normalizarLink(string $href): string
    {
        $href = trim($href);
        $partes = parse_url($href);

        if (!empty($partes['host']) && in_array(strtolower($partes['host']), self::HOSTS_PROPRIOS, true) && !empty($partes['path'])) {
            return rawurldecode(ltrim($partes['path'], '/'));
        }

        return $href;
    }

    private function parseData(string $valor): ?Carbon
    {
        if (preg_match('#(\d{2})/(\d{2})/(\d{4})#', $valor, $m)) {
            return Carbon::createFromDate((int) $m[3], (int) $m[2], (int) $m[1])->startOfDay();
        }

        return null;
    }
}
