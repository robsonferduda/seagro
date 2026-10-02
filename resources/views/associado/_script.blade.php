<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[data-cpf]').forEach(function (campo) {
        var formatar = function () {
            var d = campo.value.replace(/\D/g, '').slice(0, 11);
            var r = d.slice(0, 3);
            if (d.length > 3) r += '.' + d.slice(3, 6);
            if (d.length > 6) r += '.' + d.slice(6, 9);
            if (d.length > 9) r += '-' + d.slice(9, 11);
            campo.value = r;
        };
        campo.addEventListener('input', formatar);
        formatar();
    });

    document.querySelectorAll('.as-senha button').forEach(function (botao) {
        botao.addEventListener('click', function () {
            var campo = botao.parentNode.querySelector('input');
            var mostrar = campo.type === 'password';
            campo.type = mostrar ? 'text' : 'password';
            botao.querySelector('i').className = mostrar ? 'bi bi-eye-slash' : 'bi bi-eye';
            botao.setAttribute('aria-label', mostrar ? 'Ocultar senha' : 'Mostrar senha');
        });
    });
});
</script>
