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

        return $html;
    }
}
