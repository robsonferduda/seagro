<?php

namespace App\Models;

class Utils
{
    public static function limpaCPF_CNPJ($valor)
    {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        $valor = str_replace(" ", "", $valor);

        return $valor;
    }

    public static function decompoesGabarito($resposta){
        $arrayProp = array();

        If ($resposta >= 64) {
           $arrayProp[64] = "X";
           $resposta = $resposta - 64;
        }
        If ($resposta >= 32) {
           $arrayProp[32] = "X";
           $resposta = $resposta - 32;
        }
        If ($resposta >= 16) {
           $arrayProp[16] = "X";
           $resposta = $resposta - 16;
        }
        If ($resposta >= 8) {
           $arrayProp[8] = "X";
           $resposta = $resposta - 8;
        }
        If ($resposta >= 4) {
            $arrayProp[4] = "X";
            $resposta = $resposta - 4;
        }
        If ($resposta >= 2) {
            $arrayProp[2] = "X";
            $resposta = $resposta - 2;
        }
        If ($resposta >= 1) {
           $arrayProp[1] = "X";
           $resposta = $resposta - 1;
        }

        return $arrayProp;
    }

    public static function upperCase($texto){
        
        return strtr(strtoupper($texto),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿº","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞßº");
        
    }

    public static function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
    {
        $senha = "";
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
      $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
      $nu = "0123456789"; // $nu contem os números
      $si = "!@#$%¨&*()_+="; // $si contem os símbolos

      if ($maiusculas) {
          // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável senha
          $senha .= str_shuffle($ma);
      }

        if ($minusculas) {
            // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável senha
            $senha .= str_shuffle($mi);
        }

        if ($numeros) {
            // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável senha
            $senha .= str_shuffle($nu);
        }

        if ($simbolos) {
            // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável senha
            $senha .= str_shuffle($si);
        }

        // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável tamanho
        return substr(str_shuffle($senha), 0, $tamanho);
    }

    public static function get_post_action($name)
    {
        $params = func_get_args();

        foreach ($params as $name) {
            if (isset($_GET[$name])) {
                return $name;
            }
        }
    }

    public static function getDatabaseMessageByCode($errorCode)
    {
        switch ($errorCode) {

            case '23502':
                return 'A restrição de valores não nulos foi violada';
                break;

            case '23505':
                return 'Violação de restrição de valor único';
                break;
            case '42703':
                return 'Coluna não existe';
                break;
            default:
                return 'Código de erro desconhecido: '.$errorCode;
                break;
        }
    }

    public static function removerAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
    }

    public static function formataCPF($cpf){

          while (strlen($cpf) < 11) {
              $cpf = "0".$cpf;
          }

        return $cpf;
    }

    public static function mascaraCPF($cpf){

        $p1 = substr($cpf,0,3);
        $p2 = substr($cpf,3,3);
        $p3 = substr($cpf,6,3);
        $p4 = substr($cpf,9,2);

        return $cpf = $p1.".".$p2.".".$p3."-".$p4;
    }

    public static function removeMascaraCPF($cpf){

        $cpf = str_replace(".","",$cpf);
        $cpf = str_replace("-","",$cpf);
        return $cpf;

    }

    public static function removeMascaraTelefone($fone){

        $fone = str_replace("(","",$fone);
        $fone = str_replace(")","",$fone);
        $fone = str_replace("-","",$fone);
        $fone = str_replace(" ","",$fone);
        return $fone;

    }

    public static function mascaraTelefone($telefone){

        switch (strlen($telefone)) {
            case '8':
                $p1 = 'XX';
                $p2 = substr($telefone,0,4);
                $p3 = substr($telefone,4,4);
              break;
            case '9':
                $p1 = 'XX';
                $p2 = substr($telefone,0,4);
                $p3 = substr($telefone,4,5);
              break;
            case '10':
                $p1 = substr($telefone,0,2);
                $p2 = substr($telefone,2,4);
                $p3 = substr($telefone,6,4);
              break;
            case '11':
                $p1 = substr($telefone,0,2);
                $p2 = substr($telefone,2,4);
                $p3 = substr($telefone,6,5);
              break;
            default:
                return $telefone;
                break;
        }
        if(strlen($telefone)>=8)
            return $telefone = "(".$p1.") ".$p2."-".$p3;
        else
            return null;
    }

    public static function removeAcentos($Msg) {

        $a = array(
            '/[ÂÀÁÄÃ]/'=>'A',
            '/[âãàáä]/'=>'a',
            '/[ÊÈÉË]/'=>'E',
            '/[êèéë]/'=>'e',
            '/[ÎÍÌÏ]/'=>'I',
            '/[îíìï]/'=>'i',
            '/[ÔÕÒÓÖ]/'=>'O',
            '/[ôõòóö]/'=>'o',
            '/[ÛÙÚÜ]/'=>'U',
            '/[ûúùü]/'=>'u',
            '/(ñ)/'=>'n',
            '/(Ñ)/'=>'N',
            '/ç/'=>'c',
            '/Ç/'=> 'C');
        // Tira o acento pela chave do array
        return preg_replace(array_keys($a), array_values($a), $Msg);
    }

    public static function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    public static function criticaDigitoContaBB($nuContaBancaria,$dgContaBancaria) {

        $error = true;

        while (strlen($nuContaBancaria) < 8) {
            $nuContaBancaria = '0' . $nuContaBancaria;
        }

        $total = substr($nuContaBancaria, 7,1) * 9 +
                 substr($nuContaBancaria, 6,1) * 8 +
                 substr($nuContaBancaria, 5,1) * 7 +
                 substr($nuContaBancaria, 4,1) * 6 +
                 substr($nuContaBancaria, 3,1) * 5 +
                 substr($nuContaBancaria, 2,1) * 4 +
                 substr($nuContaBancaria, 1,1) * 3 +
                 substr($nuContaBancaria, 0,1) * 2;

        $resto = $total % 11;

        if($resto > 9){
            $digitoAux = 'X';
        }else{
            if($resto <= 0){
                $digitoAux = '0';
            }else{
                $digitoAux = "$resto";
            }
        }

        if($digitoAux == $dgContaBancaria)
            $error = false;

        return $error;
    }

    public static function criticaDigitoPIS($attribute, $nuPIS, $parameters=null, $validator=null){ /*metodo usado no IsentosEditarRequest, por isso os 4 parametros. Para usar fora do Request é só fazer criticaDigitoPIS(null, numeroPIS) */

        $error = false;

        $nuPIS = preg_replace( '/[^0-9]/is', '', $nuPIS );

        $pis10 = substr($nuPIS, 0,10);
        $digitoLido1 = substr($nuPIS, 10,1);

        $total = substr($pis10, 9,1) * 2 +
                 substr($pis10, 8,1) * 3 +
                 substr($pis10, 7,1) * 4 +
                 substr($pis10, 6,1) * 5 +
                 substr($pis10, 5,1) * 6 +
                 substr($pis10, 4,1) * 7 +
                 substr($pis10, 3,1) * 8 +
                 substr($pis10, 2,1) * 9 +
                 substr($pis10, 1,1) * 2 +
                 substr($pis10, 0,1) * 3;

        $resto = $total % 11;

        if($resto == 0 || $resto == 1){
            $digitoAux = 0;
        }else{
            $digitoAux = 11 - $resto;
        }

        if($digitoAux == $digitoLido1)
            $error = true;

        return $error;
    }

    public static function rrmdir($dir) {
       if (is_dir($dir)) {
         $objects = scandir($dir);
         foreach ($objects as $object) {
           if ($object != "." && $object != "..") {
             if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
           }
         }
         reset($objects);
         rmdir($dir);
       }
    }

    public static function formataNomeArquivo($texto){

        $padrao = array("/"," ","-", "–");
        
        return str_replace($padrao,"_",strtolower(Utils::removerAcentos($texto)));
        
    }

    public static function formataMes($mes)
    {
        $mes_extenso = "";

        switch ($mes){

            case 1: $mes_extenso = 'JAN'; break;
            case 2: $mes_extenso = 'FEV'; break;
            case 3: $mes_extenso = 'MAR'; break;
            case 4: $mes_extenso = 'ABR'; break;
            case 5: $mes_extenso = 'MAI'; break;
            case 6: $mes_extenso = 'JUN'; break;
            case 7: $mes_extenso = 'JUL'; break;
            case 8: $mes_extenso = 'AGO'; break;
            case 9: $mes_extenso = 'SET'; break;
            case 10: $mes_extenso = 'OUT'; break;
            case 11: $mes_extenso = 'NOV'; break;
            case 12: $mes_extenso = 'DEZ'; break;
        }
        return $mes_extenso;
    }

}
