<h4>Email enviado pelo formulário de contato do site</h4>
<h4>Os dados da mensagem são:</h4>
<p><strong>Nome</strong>: {{ $nome }}</p>
<p><strong>Email</strong>: {{ $email }}</p>
<p><strong>Telefone Celular</strong>: {{ ($celular) ? $celular : "Não informado" }}</p>
<p><strong>Telefone Fixo</strong>: {{ ($fixo) ? $fixo : "Não informado" }}</p>
<p><strong>Mensagem</strong>: {{ $mensagem }}</p>