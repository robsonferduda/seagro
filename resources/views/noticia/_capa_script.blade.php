<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
<style>
#modalRecorteCapa .cropper-view-box::after {
    content: "";
    position: absolute;
    left: 0; right: 0; bottom: 0;
    height: 18%;
    background: rgba(21, 65, 102, 0.55);
    pointer-events: none;
}
</style>
<script>
(function ($) {
    var PROPORCAO = {{ \App\Models\Noticia::PROPORCAO_CAPA }};
    var TOLERANCIA = {{ \App\Models\Noticia::TOLERANCIA_CAPA }};
    var LARGURA_MIN = 1000;
    var LARGURA_RECORTE = {{ \App\Support\ImagemCapa::LARGURA_MAX }};
    var LIMITE_MB = 5;

    var $input = $('#img_capa');
    var original = null;
    var cropper = null;

    $('#modalRecorteCapa').appendTo('body');

    function proporcaoTexto(w, h) {
        var r = w / h;
        var conhecidas = [[4 / 3, '4:3'], [3 / 2, '3:2'], [16 / 9, '16:9'], [1, '1:1'], [3 / 4, '3:4'], [9 / 16, '9:16'], [2, '2:1']];
        for (var i = 0; i < conhecidas.length; i++) {
            if (Math.abs(r / conhecidas[i][0] - 1) < 0.03) return conhecidas[i][1];
        }
        return r.toFixed(2).replace('.', ',') + ':1';
    }

    function tamanho(bytes) {
        return bytes >= 1048576 ? (bytes / 1048576).toFixed(1).replace('.', ',') + ' MB' : Math.ceil(bytes / 1024) + ' KB';
    }

    function diagnosticar(w, h, bytes, recortada) {
        var desvio = Math.abs((w / h) / PROPORCAO - 1);
        var cobre = desvio <= TOLERANCIA;
        var avisos = [];

        if (!cobre) {
            avisos.push(w / h > PROPORCAO
                ? 'Imagem mais larga que 4:3: aparecerá <strong>inteira</strong>, com faixas de fundo desfocado em cima e embaixo.'
                : 'Imagem mais alta que 4:3: aparecerá <strong>inteira</strong>, com faixas de fundo desfocado nas laterais.');
        }
        if (w < LARGURA_MIN) {
            avisos.push('Largura de ' + w + 'px: pode ficar sem nitidez no carrossel grande (ideal: 1200px ou mais).');
        }
        if (bytes && bytes > LIMITE_MB * 1048576) {
            avisos.push('Arquivo de ' + tamanho(bytes) + ' passa do limite de ' + LIMITE_MB + 'MB. Use <strong>Recortar 4:3</strong> para reduzir.');
        }

        var info = '<strong>' + w + '×' + h + ' px</strong> · ' + proporcaoTexto(w, h) + (bytes ? ' · ' + tamanho(bytes) : '') + (recortada ? ' · recortada' : '');
        var $s = $('#capaStatus').removeClass('d-none ok aviso');

        if (avisos.length) {
            $s.addClass('aviso').html('<i class="fa fa-exclamation-triangle"></i> ' + info + '<br>' + avisos.join('<br>'));
        } else {
            $s.addClass('ok').html('<i class="fa fa-check-circle"></i> ' + info + ' — formato ideal para o carrossel.');
        }

        $('#capaQuadro').toggleClass('is-contain', !cobre);
        return { cobre: cobre, excede: bytes > LIMITE_MB * 1048576 };
    }

    function mostrar(src, bytes, recortada) {
        var img = new Image();
        img.onload = function () {
            $('#preview-image').attr('src', src).show();
            $('#capaFundo').css('background-image', 'url("' + src + '")');
            $('#capa-empty').hide();
            diagnosticar(img.naturalWidth, img.naturalHeight, bytes, recortada);
        };
        img.src = src;
    }

    function definirArquivo(arquivo) {
        var dt = new DataTransfer();
        dt.items.add(arquivo);
        $input[0].files = dt.files;
    }

    $('#titulo').on('input', function () {
        $('#capaLegenda').text($.trim($(this).val()) || 'Título da notícia');
    });

    $input.on('change', function () {
        var arquivo = this.files && this.files[0];
        if (!arquivo) return;
        original = arquivo;
        $(this).next('.custom-file-label').text(arquivo.name);
        $('#btnRecortarCapa').removeClass('d-none');
        $('#btnDesfazerRecorte').addClass('d-none');

        var reader = new FileReader();
        reader.onload = function (e) { mostrar(e.target.result, arquivo.size, false); };
        reader.readAsDataURL(arquivo);
    });

    var imagemExistente = $('#preview-image').attr('src');
    if (imagemExistente) {
        var atual = new Image();
        atual.onload = function () { diagnosticar(atual.naturalWidth, atual.naturalHeight, 0, false); };
        atual.src = imagemExistente;
    }

    $('#btnRecortarCapa').on('click', function () {
        if (!original) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#recorteImagem').attr('src', e.target.result);
            $('#modalRecorteCapa').modal('show');
        };
        reader.readAsDataURL(original);
    });

    $('#modalRecorteCapa').on('shown.bs.modal', function () {
        if (cropper) cropper.destroy();
        cropper = new Cropper(document.getElementById('recorteImagem'), {
            aspectRatio: PROPORCAO,
            viewMode: 1,
            autoCropArea: 1,
            dragMode: 'move',
            background: false
        });
    }).on('hidden.bs.modal', function () {
        if (cropper) { cropper.destroy(); cropper = null; }
    });

    $('#btnAplicarRecorte').on('click', function () {
        if (!cropper) return;
        var dados = cropper.getData(true);
        var largura = Math.min(LARGURA_RECORTE, dados.width);
        var canvas = cropper.getCroppedCanvas({
            width: largura,
            height: Math.round(largura / PROPORCAO),
            fillColor: '#fff',
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        canvas.toBlob(function (blob) {
            var nome = (original.name || 'capa').replace(/\.[^.]+$/, '') + '-4x3.jpg';
            var arquivo = new File([blob], nome, { type: 'image/jpeg', lastModified: Date.now() });
            definirArquivo(arquivo);
            $input.next('.custom-file-label').text(nome);
            mostrar(canvas.toDataURL('image/jpeg', 0.9), arquivo.size, true);
            $('#btnDesfazerRecorte').removeClass('d-none');
            $('#modalRecorteCapa').modal('hide');
        }, 'image/jpeg', 0.9);
    });

    $('#btnDesfazerRecorte').on('click', function () {
        if (!original) return;
        definirArquivo(original);
        $input.next('.custom-file-label').text(original.name);
        var reader = new FileReader();
        reader.onload = function (e) { mostrar(e.target.result, original.size, false); };
        reader.readAsDataURL(original);
        $(this).addClass('d-none');
    });

    $input.closest('form').on('submit', function (e) {
        var arquivo = $input[0].files && $input[0].files[0];
        if (arquivo && arquivo.size > LIMITE_MB * 1048576) {
            e.preventDefault();
            e.stopImmediatePropagation();
            Swal.fire({
                icon: 'warning',
                title: 'Imagem muito grande',
                html: 'A capa tem ' + tamanho(arquivo.size) + ' e o limite é ' + LIMITE_MB + 'MB.<br>Use <strong>Recortar 4:3</strong>, que reduz o arquivo automaticamente.'
            });
        }
    });
})(jQuery);
</script>
