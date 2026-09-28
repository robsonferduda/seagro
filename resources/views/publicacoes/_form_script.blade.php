<script>
$(document).ready(function () {
    var temArquivoAtual = {{ !empty($publicacao) && $publicacao->exists && $publicacao->arquivo ? 'true' : 'false' }};

    function tamanho(bytes) {
        return bytes >= 1048576 ? (bytes / 1048576).toFixed(1).replace('.', ',') + ' MB' : Math.ceil(bytes / 1024) + ' KB';
    }

    $('.nf-file-input').on('change', function () {
        var $box = $(this).closest('.nf-file');
        var $nome = $box.find('.nf-file-nome');
        var arquivo = this.files && this.files[0];
        $box.toggleClass('selecionado', !!arquivo);
        $nome.text(arquivo ? arquivo.name + ' (' + tamanho(arquivo.size) + ')' : $nome.data('padrao'));
    });

    $('#formPublicacao').on('submit', function (e) {
        var arquivo = $('#arquivo')[0].files[0];
        var link = $.trim($('#link_externo').val());
        var erro = null;

        if (!arquivo && !link && !temArquivoAtual) {
            erro = 'Envie um arquivo ou informe um link externo.';
        } else if (arquivo && arquivo.size > 20 * 1024 * 1024) {
            erro = 'O arquivo não pode ser maior que 20MB.';
        } else if (arquivo && !/\.(pdf|docx?)$/i.test(arquivo.name)) {
            erro = 'O arquivo deve ser PDF, DOC ou DOCX.';
        }

        if (erro) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Verifique o arquivo', text: erro });
            return;
        }

        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
    });
});
</script>
