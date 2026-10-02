<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

class ImagemCapa
{
    public const LARGURA_MAX = 1600;
    public const ALTURA_MAX = 1600;
    public const QUALIDADE_JPG = 82;

    /**
     * Salva a imagem redimensionada e comprimida em JPG. Sem GD, ou se a conversão falhar,
     * o arquivo original é salvo como veio.
     *
     * @return string nome do arquivo gravado em $pasta
     */
    public static function salvar(UploadedFile $arquivo, string $pasta, string $nomeBase): string
    {
        if (!is_dir($pasta)) {
            mkdir($pasta, 0775, true);
        }

        $extensaoOriginal = strtolower($arquivo->getClientOriginalExtension() ?: $arquivo->extension());

        try {
            $nome = self::otimizar($arquivo->getRealPath(), $pasta, $nomeBase, $extensaoOriginal);
            if ($nome !== null) {
                return $nome;
            }
        } catch (\Throwable $e) {
            report($e);
        }

        $nome = $nomeBase . '.' . $extensaoOriginal;
        $arquivo->move($pasta, $nome);

        return $nome;
    }

    private static function otimizar(string $origem, string $pasta, string $nomeBase, string $extensaoOriginal): ?string
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        $info = @getimagesize($origem);
        if (!$info) {
            return null;
        }

        [$largura, $altura, $tipo] = $info;

        // GIF pode ser animado; reencodar perderia a animação.
        if (!in_array($tipo, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            return null;
        }

        @ini_set('memory_limit', '512M');

        switch ($tipo) {
            case IMAGETYPE_JPEG:
                $imagem = @imagecreatefromjpeg($origem);
                break;
            case IMAGETYPE_PNG:
                $imagem = @imagecreatefrompng($origem);
                break;
            default:
                $imagem = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($origem) : false;
        }

        if (!$imagem) {
            return null;
        }

        if ($tipo === IMAGETYPE_JPEG) {
            $imagem = self::corrigirOrientacao($imagem, $origem);
            $largura = imagesx($imagem);
            $altura = imagesy($imagem);
        }

        $escala = min(1, self::LARGURA_MAX / $largura, self::ALTURA_MAX / $altura);
        $novaLargura = max(1, (int) round($largura * $escala));
        $novaAltura = max(1, (int) round($altura * $escala));

        $destino = imagecreatetruecolor($novaLargura, $novaAltura);
        imagefill($destino, 0, 0, imagecolorallocate($destino, 255, 255, 255));
        imagecopyresampled($destino, $imagem, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);
        imagedestroy($imagem);

        $nome = $nomeBase . '.jpg';
        $caminho = rtrim($pasta, '/') . '/' . $nome;

        imageinterlace($destino, true);
        $ok = imagejpeg($destino, $caminho, self::QUALIDADE_JPG);
        imagedestroy($destino);

        if (!$ok || !file_exists($caminho)) {
            return null;
        }

        // Um JPG já leve e no tamanho certo pode ficar maior ao ser recomprimido.
        if ($escala === 1 && $tipo === IMAGETYPE_JPEG && filesize($caminho) >= filesize($origem)) {
            @unlink($caminho);
            $nome = $nomeBase . '.' . ($extensaoOriginal === 'jpeg' ? 'jpeg' : 'jpg');
            copy($origem, rtrim($pasta, '/') . '/' . $nome);
        }

        return $nome;
    }

    private static function corrigirOrientacao($imagem, string $origem)
    {
        if (!function_exists('exif_read_data')) {
            return $imagem;
        }

        $exif = @exif_read_data($origem);
        $orientacao = (int) ($exif['Orientation'] ?? 1);
        $angulos = [3 => 180, 6 => -90, 8 => 90];

        if (isset($angulos[$orientacao])) {
            $rotacionada = imagerotate($imagem, $angulos[$orientacao], 0);
            if ($rotacionada) {
                imagedestroy($imagem);
                return $rotacionada;
            }
        }

        return $imagem;
    }
}
