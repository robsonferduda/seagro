<script>
window.SeagroGaleriaPicker = {
    targetId: null,
    url: @json(url('galeria/json')),
    open: function (editorId) {
        this.targetId = editorId || 'corpo';
        $('#modalGaleriaPicker').modal('show');
        this.load($('#galeriaPickerBusca').val() || '');
    },
    load: function (q) {
        var self = this;
        var $grid = $('#galeriaPickerGrid').html(
            '<div class="galeria-picker-loading text-muted text-center py-4"><i class="fa fa-spinner fa-spin"></i> Carregando...</div>'
        );
        $.getJSON(self.url, { q: q || '' })
            .done(function (res) {
                var imagens = res.imagens || [];
                if (!imagens.length) {
                    $grid.html('<div class="text-center text-muted py-4">Nenhuma imagem na galeria.<br><a href="' + @json(url('galeria/create')) + '" target="_blank">Enviar imagens</a></div>');
                    return;
                }
                var html = '';
                imagens.forEach(function (img) {
                    var url = String(img.url || '').replace(/"/g, '&quot;');
                    var titulo = String(img.titulo || 'Imagem').replace(/</g, '&lt;').replace(/"/g, '&quot;');
                    html += '<div class="galeria-picker-item" data-url="' + url + '" title="' + titulo + '">' +
                        '<img src="' + url + '" alt="">' +
                        '<span>' + titulo + '</span></div>';
                });
                $grid.html(html);
            })
            .fail(function () {
                $grid.html('<div class="text-center text-danger py-4">Erro ao carregar a galeria.</div>');
            });
    },
    insert: function (url) {
        var $el = $('#' + (this.targetId || 'corpo'));
        if ($el.length && $el.next('.note-editor').length) {
            $el.summernote('focus');
            $el.summernote('insertImage', url, function ($image) {
                $image.css('width', '100%');
            });
        }
        $('#modalGaleriaPicker').modal('hide');
    }
};

$(document).on('click', '#galeriaPickerBuscar', function () {
    window.SeagroGaleriaPicker.load($('#galeriaPickerBusca').val());
});
$(document).on('keydown', '#galeriaPickerBusca', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        window.SeagroGaleriaPicker.load($(this).val());
    }
});
$(document).on('click', '.galeria-picker-item', function () {
    window.SeagroGaleriaPicker.insert($(this).attr('data-url'));
});
</script>
