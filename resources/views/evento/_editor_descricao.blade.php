<script>
    window.SeagroEventoEditor = window.SeagroEventoEditor || {
        init: function (elementId) {
            var $el = $('#' + elementId);
            if (!$el.length || typeof $.fn.summernote === 'undefined') {
                return null;
            }

            if ($el.next('.note-editor').length) {
                return $el;
            }

            $el.summernote({
                lang: 'pt-BR',
                height: 280,
                placeholder: 'Texto, links e informações do evento...',
                disableDragAndDrop: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'hr']],
                    ['view', ['codeview', 'undo', 'redo']]
                ],
                styleTags: ['p', 'h2', 'h3', 'h4'],
                dialogsInBody: true
            });

            return $el;
        },
        resize: function (elementId) {
            var $el = $('#' + elementId);
            if (!$el.length || !$el.next('.note-editor').length) {
                return;
            }
            try {
                $el.summernote('focus');
            } catch (e) {}
        },
        sync: function (elementId) {
            var $el = $('#' + (elementId || 'descricao'));
            if (!$el.length || typeof $.fn.summernote === 'undefined') {
                return;
            }
            if ($el.next('.note-editor').length) {
                $el.val($el.summernote('code'));
            }
        }
    };
</script>
