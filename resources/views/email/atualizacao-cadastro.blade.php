<h4>Solicitação de atualização de cadastro enviada pelo site</h4>
<h4>Os dados informados são:</h4>
<p><strong>Nome</strong>: {{ $nome }}</p>
<p><strong>Telefone/Celular</strong>: {{ $telefone }}</p>
<p><strong>E-mail</strong>: {{ $email }}</p>
<p><strong>Endereço Completo</strong>: {{ $endereco }}</p>
<p><strong>Empresa</strong>: {{ $empresa }}</p>
<p><strong>Local de Trabalho</strong>: {{ $local_trabalho }}</p>
<p><strong>Informações Complementares</strong>: {{ $informacoes_complementares ? $informacoes_complementares : 'Não informado' }}</p>