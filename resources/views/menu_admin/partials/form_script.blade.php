<script>
$(document).ready(function () {
    var urlTouched = {!! (old('url') !== null ? old('url') : (isset($menu) ? $menu->url : null)) ? 'true' : 'false' !!};

    $('#url').on('input', function () {
        urlTouched = $(this).val().trim() !== '';
    });

    $('#id_pagina').on('change', function () {
        var opt = $(this).find('option:selected');
        var apelido = opt.data('apelido');
        if (!apelido) {
            return;
        }
        if (!urlTouched || $('#url').val().trim() === '' || $('#url').val().indexOf('pagina/') === 0) {
            $('#url').val('pagina/' + apelido);
            urlTouched = false;
        }
    });

    $('#formMenu').on('submit', function () {
        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
    });
});
</script>
