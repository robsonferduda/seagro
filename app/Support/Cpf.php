<?php

namespace App\Support;

class Cpf
{
    public static function limpar($cpf): string
    {
        return preg_replace('/\D/', '', (string) $cpf);
    }

    public static function valido($cpf): bool
    {
        $cpf = self::limpar($cpf);

        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($posicao = 9; $posicao < 11; $posicao++) {
            $soma = 0;
            for ($i = 0; $i < $posicao; $i++) {
                $soma += (int) $cpf[$i] * (($posicao + 1) - $i);
            }
            $digito = ((10 * $soma) % 11) % 10;
            if ((int) $cpf[$posicao] !== $digito) {
                return false;
            }
        }

        return true;
    }

    public static function formatar($cpf): string
    {
        $cpf = self::limpar($cpf);

        if (strlen($cpf) !== 11) {
            return $cpf;
        }

        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    public static function mascarar($cpf): string
    {
        $cpf = self::limpar($cpf);

        if (strlen($cpf) !== 11) {
            return $cpf;
        }

        return '***.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-**';
    }
}
