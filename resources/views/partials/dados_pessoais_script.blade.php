{{-- Máscaras, UF → cidades e busca de CEP (ViaCEP) do bloco de dados pessoais. Sem dependência de jQuery. --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var urlCidades = @json(url('cidades'));

    function digitos(valor) {
        return (valor || '').replace(/\D/g, '');
    }

    function formatarCep(d) {
        d = d.slice(0, 8);
        return d.length > 5 ? d.slice(0, 5) + '-' + d.slice(5) : d;
    }

    function formatarTelefone(d) {
        d = d.slice(0, 11);
        if (!d) return '';
        if (d.length <= 2) return '(' + d;
        var resto = d.slice(2);
        var corte = resto.length > 8 ? 5 : 4;
        return '(' + d.slice(0, 2) + ') ' + (resto.length > corte ? resto.slice(0, corte) + '-' + resto.slice(corte) : resto);
    }

    function mascarar(campo, formatador) {
        var aplicar = function () { campo.value = formatador(digitos(campo.value)); };
        campo.addEventListener('input', aplicar);
        aplicar();
    }

    document.querySelectorAll('input[data-telefone]').forEach(function (campo) {
        mascarar(campo, formatarTelefone);
    });

    function carregarCidades(ufSelect, cidadeSelect, selecionar) {
        var uf = ufSelect.value;
        cidadeSelect.innerHTML = '';
        cidadeSelect.add(new Option(uf ? 'Carregando...' : 'Selecione a UF', ''));
        cidadeSelect.disabled = true;

        if (!uf) return;

        fetch(urlCidades + '/' + encodeURIComponent(uf), { headers: { 'Accept': 'application/json' } })
            .then(function (resposta) { return resposta.json(); })
            .then(function (cidades) {
                cidadeSelect.innerHTML = '';
                cidadeSelect.add(new Option('Selecione...', ''));
                cidades.forEach(function (cidade) {
                    cidadeSelect.add(new Option(cidade.nome, cidade.id));
                });
                cidadeSelect.disabled = false;
                if (selecionar) cidadeSelect.value = String(selecionar);
            })
            .catch(function () {
                cidadeSelect.innerHTML = '';
                cidadeSelect.add(new Option('Não foi possível carregar as cidades', ''));
            });
    }

    document.querySelectorAll('select[data-uf-cidade]').forEach(function (ufSelect) {
        var cidadeSelect = document.getElementById(ufSelect.getAttribute('data-uf-cidade'));
        ufSelect.addEventListener('change', function () {
            carregarCidades(ufSelect, cidadeSelect);
        });
    });

    var cep = document.getElementById('cep');
    if (!cep) return;

    var status = document.getElementById('cepStatus');
    var avisar = function (texto, erro) {
        if (!status) return;
        status.textContent = texto;
        status.style.color = erro ? '#c0392b' : '';
    };

    mascarar(cep, formatarCep);

    cep.addEventListener('input', function () {
        var d = digitos(cep.value);
        if (d.length !== 8) {
            avisar('');
            return;
        }
        if (d === cep.getAttribute('data-consultado')) return;
        cep.setAttribute('data-consultado', d);
        avisar('Buscando endereço...');

        fetch('https://viacep.com.br/ws/' + d + '/json/')
            .then(function (resposta) { return resposta.json(); })
            .then(function (endereco) {
                if (endereco.erro) {
                    avisar('CEP não encontrado. Preencha o endereço manualmente.', true);
                    return;
                }
                avisar('');
                if (endereco.logradouro) document.getElementById('logradouro').value = endereco.logradouro;
                if (endereco.bairro) document.getElementById('bairro').value = endereco.bairro;

                var ufSelect = document.getElementById('uf_residencia');
                ufSelect.value = endereco.uf;
                carregarCidades(ufSelect, document.getElementById('id_cidade'), endereco.ibge);

                document.getElementById(endereco.logradouro ? 'numero' : 'logradouro').focus();
            })
            .catch(function () {
                avisar('Não foi possível consultar o CEP agora. Preencha o endereço manualmente.', true);
            });
    });
});
</script>
