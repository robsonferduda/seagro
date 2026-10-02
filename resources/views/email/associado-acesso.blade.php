<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>SEAGRO-SC - Área do Associado</title>
</head>
<body style="margin:0;padding:0;background:#f3f6f9;font-family:Arial,Helvetica,sans-serif;color:#2c3e50;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f6f9;padding:24px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="max-width:560px;background:#ffffff;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="background:#154166;color:#ffffff;padding:22px 28px;font-size:18px;font-weight:bold;">
                            SEAGRO-SC &middot; Área do Associado
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;font-size:15px;line-height:1.6;">
                            <p style="margin:0 0 14px;">Olá, {{ $nome }}!</p>
                            @if($primeiroAcesso)
                                <p style="margin:0 0 14px;">Seu cadastro na Área do Associado do SEAGRO-SC está pronto. Clique no botão abaixo para criar sua senha de acesso.</p>
                            @else
                                <p style="margin:0 0 14px;">Recebemos um pedido para redefinir a senha da sua conta na Área do Associado. Clique no botão abaixo para escolher uma nova senha.</p>
                            @endif
                            <p style="margin:24px 0;text-align:center;">
                                <a href="{{ $link }}" style="display:inline-block;background:#336693;color:#ffffff;text-decoration:none;padding:12px 26px;border-radius:6px;font-weight:bold;">
                                    {{ $primeiroAcesso ? 'Criar minha senha' : 'Redefinir minha senha' }}
                                </a>
                            </p>
                            <p style="margin:0 0 14px;font-size:13px;color:#6b7c8f;">
                                Na página que abrir, confirme seu CPF e escolha a senha. Depois, entre usando seu CPF e essa senha.
                                O link vale por {{ $validadeHoras }} horas.
                            </p>
                            <p style="margin:0 0 14px;font-size:13px;color:#6b7c8f;">
                                Se o botão não funcionar, copie e cole este endereço no navegador:<br>
                                <a href="{{ $link }}" style="color:#336693;word-break:break-all;">{{ $link }}</a>
                            </p>
                            <p style="margin:0;font-size:13px;color:#6b7c8f;">Se você não fez esse pedido, ignore este e-mail.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f5f8fb;padding:16px 28px;font-size:12px;color:#8395a7;">
                            SEAGRO-SC &middot; seagro@seagro-sc.org.br &middot; (48) 3224-5681
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
