<?php

namespace App\Support;

class HtmlLimpeza
{
    /**
     * Remove caracteres invisíveis e atributos que acompanham textos colados do ChatGPT.
     */
    public static function limpar(?string $html): string
    {
        $html = (string) $html;

        $padroes = [
            '/[\x{FEFF}\x{200B}\x{200C}\x{200D}]/u' => '',
            '/\sdata-(start|end|section-id|is-last-node|is-only-node|spread)="[^"]*"/i' => '',
            '/\sclass="(isSelectedEnd)?"/i' => '',
        ];

        foreach ($padroes as $padrao => $substituto) {
            $resultado = preg_replace($padrao, $substituto, $html);
            if ($resultado !== null) {
                $html = $resultado;
            }
        }

        return self::vazio($html) ? '' : $html;
    }

    /**
     * O Summernote salva "<p><br></p>" (e variações com span) quando o editor está vazio.
     */
    public static function vazio(string $html): bool
    {
        if (preg_match('/<(img|iframe|video|audio|table|hr|embed|object)\b/i', $html)) {
            return false;
        }

        $texto = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(str_replace("\xC2\xA0", ' ', $texto)) === '';
    }
}
