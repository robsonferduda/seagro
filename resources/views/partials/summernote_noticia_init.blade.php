{{-- Inicialização do Summernote para notícias (tamanhos sempre em px) --}}
<script>
window.SeagroNoticiaEditor = {
    /**
     * Converte font-size em em/rem/pt/% e <font size> para pixels reais.
     * Evita o bug do Summernote: texto em 2em aparece como "2" e ao escolher 8 aplica 8em.
     */
    normalizeFontSizes: function (root) {
        if (!root) return;

        var htmlSizeMap = { 1: 10, 2: 13, 3: 16, 4: 18, 5: 24, 6: 32, 7: 48 };
        var fonts = root.querySelectorAll('font[size]');
        Array.prototype.forEach.call(fonts, function (el) {
            var n = parseInt(el.getAttribute('size'), 10);
            var px = htmlSizeMap[n] || 16;
            var span = document.createElement('span');
            span.style.fontSize = px + 'px';
            if (el.getAttribute('color')) {
                span.style.color = el.getAttribute('color');
            }
            if (el.getAttribute('face')) {
                span.style.fontFamily = el.getAttribute('face');
            }
            while (el.firstChild) {
                span.appendChild(el.firstChild);
            }
            el.parentNode.replaceChild(span, el);
        });

        var nodes = root.querySelectorAll('[style*="font-size"]');
        Array.prototype.forEach.call(nodes, function (el) {
            var inline = el.style ? el.style.fontSize : '';
            if (!inline || /px$/i.test(inline.trim())) {
                return;
            }
            var computed = window.getComputedStyle(el).fontSize;
            if (computed) {
                el.style.fontSize = computed;
            }
        });
    },

    init: function (editorId) {
        var self = this;
        var $el = $('#' + (editorId || 'corpo'));
        if (!$el.length || typeof $.fn.summernote === 'undefined') {
            return;
        }

        var GaleriaButton = function (context) {
            var ui = $.summernote.ui;
            return ui.button({
                contents: '<i class="fa fa-picture-o"></i> Galeria',
                tooltip: 'Inserir imagem da galeria',
                click: function () {
                    window.SeagroGaleriaPicker.open(editorId || 'corpo');
                }
            }).render();
        };

        $el.summernote({
            lang: 'pt-BR',
            height: 420,
            placeholder: 'Escreva o conteúdo da notícia...',
            dialogsInBody: true,
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48'],
            fontSizeUnits: ['px'],
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'hr', 'galeria']],
                ['view', ['fullscreen', 'codeview', 'undo', 'redo']]
            ],
            buttons: { galeria: GaleriaButton },
            styleTags: ['p', 'h2', 'h3', 'h4', 'blockquote'],
            callbacks: {
                onInit: function () {
                    var editable = $el.next('.note-editor').find('.note-editable').get(0);
                    self.normalizeFontSizes(editable);
                    $el.val($el.summernote('code'));
                    // Garante unidade px no estado do editor
                    try { $el.summernote('fontSizeUnit', 'px'); } catch (e) {}
                },
                onPaste: function () {
                    var editable = $el.next('.note-editor').find('.note-editable').get(0);
                    setTimeout(function () {
                        self.normalizeFontSizes(editable);
                    }, 0);
                }
            }
        });

        // Antes de aplicar um tamanho da lista, converte a seleção atual para px
        // (senão 2em + escolher "14" vira 14em).
        $(document).on('mousedown.seagroFontSize', '.note-editor .dropdown-fontsize a', function () {
            var editable = $el.next('.note-editor').find('.note-editable').get(0);
            self.normalizeFontSizes(editable);
            try { $el.summernote('fontSizeUnit', 'px'); } catch (e) {}
        });
    },

    sync: function (editorId) {
        var $el = $('#' + (editorId || 'corpo'));
        if ($el.length && $el.next('.note-editor').length) {
            $el.val($el.summernote('code'));
        }
    }
};
</script>
