<script>
$(document).ready(function () {
    var $cpf = $('#cpf');
    $cpf.mask('000.000.000-00');

    function cpfValido(valor) {
        var cpf = (valor || '').replace(/\D/g, '');
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
        for (var t = 9; t < 11; t++) {
            var soma = 0;
            for (var i = 0; i < t; i++) soma += parseInt(cpf.charAt(i), 10) * ((t + 1) - i);
            if (parseInt(cpf.charAt(t), 10) !== ((10 * soma) % 11) % 10) return false;
        }
        return true;
    }

    function conferirCpf() {
        var digitos = $cpf.val().replace(/\D/g, '');
        var invalido = digitos.length === 11 && !cpfValido(digitos);
        $('#cpfInvalido').toggleClass('d-none', !invalido);
        return !invalido;
    }

    $cpf.on('input blur', conferirCpf);

    $('#btnVerSenha').on('click', function () {
        var $senha = $('#senha');
        var mostrar = $senha.attr('type') === 'password';
        $senha.attr('type', mostrar ? 'text' : 'password');
        $(this).find('i').attr('class', mostrar ? 'fa fa-eye-slash' : 'fa fa-eye');
    });

    $('#formAssociado').on('submit', function (e) {
        if (!cpfValido($cpf.val())) {
            e.preventDefault();
            $('#cpfInvalido').removeClass('d-none');
            $cpf.focus();
            return;
        }
        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
    });
});
</script>
