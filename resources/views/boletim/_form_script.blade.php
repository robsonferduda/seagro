<script>
$(document).ready(function () {
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: 'fa fa-clock-o', date: 'fa fa-calendar',
            up: 'fa fa-chevron-up', down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'
        }
    });

    function tamanho(bytes) {
        return bytes >= 1048576 ? (bytes / 1048576).toFixed(1).replace('.', ',') + ' MB' : Math.ceil(bytes / 1024) + ' KB';
    }

    $('.bl-file-input').on('change', function () {
        var $box = $(this).closest('.bl-file');
        var $nome = $box.find('.bl-file-nome');
        var arquivo = this.files && this.files[0];
        $box.toggleClass('selecionado', !!arquivo);
        $nome.text(arquivo ? arquivo.name + ' (' + tamanho(arquivo.size) + ')' : $nome.data('padrao'));
    });

    $('#imagem').on('change', function () {
        var arquivo = this.files && this.files[0];
        $(this).next('.custom-file-label').text(arquivo ? arquivo.name : 'Selecionar imagem');
        if (arquivo) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result).show();
                $('#capa-empty').hide();
            };
            reader.readAsDataURL(arquivo);
        }
    });

    var limites = [
        { id: 'pdf', max: 10, tipo: /pdf/i, nome: 'O PDF', formato: 'PDF' },
        { id: 'imagem', max: 5, tipo: /^image\/(jpe?g|png)$/i, nome: 'A imagem', formato: 'JPG ou PNG' },
        { id: 'audio', max: 20, tipo: /audio|mpeg/i, nome: 'O áudio', formato: 'MP3 ou WAV' }
    ];

    $('#formBoletim').on('submit', function (e) {
        var erros = [];

        limites.forEach(function (l) {
            var arquivo = $('#' + l.id)[0].files[0];
            if (!arquivo) return;
            if (arquivo.size > l.max * 1024 * 1024) erros.push(l.nome + ' não pode ser maior que ' + l.max + 'MB.');
            if (arquivo.type && !l.tipo.test(arquivo.type)) erros.push(l.nome + ' deve estar no formato ' + l.formato + '.');
        });

        if (erros.length) {
            e.preventDefault();
            Swal.fire({ icon: 'error', title: 'Verifique os arquivos', html: erros.join('<br>') });
            return;
        }

        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enviando...');
    });
});
</script>
