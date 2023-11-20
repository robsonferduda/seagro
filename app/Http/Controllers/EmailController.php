<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        
    }

    public function contato(Request $request)
    {
        $from = $request->email;
        $nome = $request->nome;
        $email = 'contato@seagro-sc.org.br';

        $destino = $request->destino;
        
        switch ($destino) {
            case 'secretaria':
                $email = "seagro@seagro-sc.org.br";
                break;
            case 'cadastro':
                $email = "cadastro@seagro-sc.org.br";
                break;
            default:
                $email = "contato@seagro-sc.org.br";
                break;
        }

        $data = array('nome' => $request->nome,
                      'email' => $request->email,
                      'celular' => $request->celular,
                      'fixo' => $request->fixo,
                      'mensagem' =>$request->message);

        Mail::send('email/contato', $data, function($message) use($email, $from, $nome) {
            $message->to($email)->subject('Contato Site');
            $message->from($from, $nome);
        });

        if(count(Mail::failures()) > 0) {
            return response()->json(['error' => 'invalid'], 400);
        }else{
            echo "OK";
        }
    }
}