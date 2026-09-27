{{-- Inicialização do Summernote para notícias (tamanhos sempre em px) --}}
<style>
.note-editable img.note-float-right,
.note-editable img[style*="float: right"] {
    margin: 0.35rem 0 1rem 1.5rem;
}
.note-editable img.note-float-left,
.note-editable img[style*="float: left"] {
    margin: 0.35rem 1.5rem 1rem 0;
}
.note-editable { line-height: 1.7; }
.note-editable p { margin-bottom: 0.9rem; }
</style>
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

    /**
     * Mantém só a estrutura (parágrafos, títulos, negrito, itálico, links, listas,
     * tabelas e imagens) e descarta fontes, cores, tamanhos e atributos de
     * Word/Google Docs/ChatGPT.
     */
    cleanHtml: function (html) {
        var ALLOWED = {
            P: 1, BR: 1, B: 1, STRONG: 1, I: 1, EM: 1, U: 1, S: 1, A: 1,
            UL: 1, OL: 1, LI: 1, H2: 1, H3: 1, H4: 1, BLOCKQUOTE: 1, HR: 1, IMG: 1,
            TABLE: 1, THEAD: 1, TBODY: 1, TR: 1, TD: 1, TH: 1
        };
        var RENAME = { H1: 'H2', H5: 'H4', H6: 'H4', DIV: 'P', STRIKE: 'S', DEL: 'S' };
        var DROP = { SCRIPT: 1, STYLE: 1, META: 1, LINK: 1, TITLE: 1, IFRAME: 1, OBJECT: 1 };
        var BLOCKS = 'p,ul,ol,h2,h3,h4,blockquote,table,hr';
        var ZERO_WIDTH = /[\uFEFF\u200B\u200C\u200D]/g;

        var doc = document.implementation.createHTMLDocument('');
        var source = doc.createElement('div');
        source.innerHTML = html || '';

        function cleanChildren(node) {
            var frag = doc.createDocumentFragment();
            Array.prototype.forEach.call(node.childNodes, function (child) {
                var cleaned = cleanNode(child);
                if (cleaned) frag.appendChild(cleaned);
            });
            return frag;
        }

        function wrapIn(tag, content) {
            var el = doc.createElement(tag);
            el.appendChild(content);
            return el;
        }

        function cleanNode(node) {
            if (node.nodeType === 3) {
                var text = node.nodeValue.replace(ZERO_WIDTH, '');
                return text ? doc.createTextNode(text) : null;
            }
            if (node.nodeType !== 1) return null;

            var original = node.tagName.toUpperCase();
            if (DROP[original]) return null;

            var tag = RENAME[original] || original;
            var style = node.getAttribute('style') || '';
            var content = cleanChildren(node);

            if ((tag === 'B' || tag === 'STRONG') && /font-weight\s*:\s*(normal|400)/i.test(style)) {
                return content;
            }

            if (!ALLOWED[tag]) {
                if (/font-weight\s*:\s*(bold|[6-9]00)/i.test(style)) content = wrapIn('B', content);
                if (/font-style\s*:\s*italic/i.test(style)) content = wrapIn('I', content);
                return content;
            }

            var el = doc.createElement(tag);

            if (tag === 'A') {
                var href = node.getAttribute('href') || '';
                if (href && !/^\s*javascript:/i.test(href)) el.setAttribute('href', href);
                if (node.getAttribute('target') === '_blank') {
                    el.setAttribute('target', '_blank');
                    el.setAttribute('rel', 'noopener');
                }
            } else if (tag === 'IMG') {
                var src = node.getAttribute('src') || '';
                if (!src) return null;
                el.setAttribute('src', src);
                el.setAttribute('alt', node.getAttribute('alt') || '');
                var width = node.style.width;
                var float = node.style.cssFloat || node.style.float;
                if (width) el.style.width = width;
                if (float === 'left' || float === 'right') {
                    el.style.cssFloat = float;
                    el.className = 'note-float-' + float;
                }
                return el;
            } else if (tag === 'TD' || tag === 'TH') {
                ['colspan', 'rowspan'].forEach(function (attr) {
                    if (node.getAttribute(attr)) el.setAttribute(attr, node.getAttribute(attr));
                });
            }

            el.appendChild(content);
            return el;
        }

        var root = doc.createElement('div');
        root.appendChild(cleanChildren(source));

        // Títulos/parágrafos com blocos dentro (<h3><p>...</p></h3>) são desmontados
        var containers = root.querySelectorAll('p, h2, h3, h4');
        for (var i = containers.length - 1; i >= 0; i--) {
            var box = containers[i];
            if (box.querySelector(BLOCKS)) {
                while (box.firstChild) box.parentNode.insertBefore(box.firstChild, box);
                box.parentNode.removeChild(box);
            }
        }

        // Texto longo formatado como título vira parágrafo
        Array.prototype.forEach.call(root.querySelectorAll('h2, h3, h4'), function (h) {
            if (h.textContent.trim().length > 160) {
                var p = doc.createElement('p');
                while (h.firstChild) p.appendChild(h.firstChild);
                h.parentNode.replaceChild(p, h);
            }
        });

        // <br> no começo/fim de blocos (usados para "dar espaço"), inclusive dentro de <b>/<i>
        function trimEdge(el, fromStart) {
            var node = fromStart ? el.firstChild : el.lastChild;
            while (node) {
                var next = fromStart ? node.nextSibling : node.previousSibling;
                var isBlank = node.nodeName === 'BR' || (node.nodeType === 3 && !node.nodeValue.trim());
                if (isBlank) {
                    el.removeChild(node);
                    node = next;
                    continue;
                }
                if (node.nodeType === 1 && /^(B|STRONG|I|EM|U|S)$/.test(node.nodeName)) {
                    trimEdge(node, fromStart);
                    if (!node.textContent.trim() && !node.querySelector('img')) {
                        el.removeChild(node);
                        node = next;
                        continue;
                    }
                }
                break;
            }
        }

        Array.prototype.forEach.call(root.querySelectorAll('p, h2, h3, h4, li'), function (el) {
            trimEdge(el, true);
            trimEdge(el, false);
            if (!el.textContent.trim() && !el.querySelector('img')) {
                el.parentNode.removeChild(el);
            }
        });

        // Parágrafo curto todo em negrito, sem pontuação final, funciona como subtítulo
        Array.prototype.forEach.call(root.querySelectorAll('p'), function (p) {
            var only = p.children.length === 1 && p.childNodes.length === 1 ? p.firstElementChild : null;
            var text = p.textContent.trim();
            if (only && /^(B|STRONG)$/.test(only.nodeName) && text.length <= 80 && !/[.:;,]$/.test(text)) {
                var h = doc.createElement('h3');
                h.appendChild(only);
                p.parentNode.replaceChild(h, p);
            }
        });

        // Negrito redundante ocupando o título inteiro
        Array.prototype.forEach.call(root.querySelectorAll('h2, h3, h4'), function (h) {
            var only = h.childNodes.length === 1 ? h.firstElementChild : null;
            if (only && /^(B|STRONG)$/.test(only.nodeName)) {
                while (only.firstChild) h.insertBefore(only.firstChild, only);
                h.removeChild(only);
            }
        });

        // Conteúdo solto no nível raiz é agrupado em parágrafos
        var result = doc.createElement('div');
        var run = null;
        Array.prototype.slice.call(root.childNodes).forEach(function (node) {
            var isBlock = node.nodeType === 1 && /^(P|UL|OL|H2|H3|H4|BLOCKQUOTE|TABLE|HR)$/.test(node.nodeName);
            if (isBlock) {
                run = null;
                result.appendChild(node);
                return;
            }
            if (node.nodeName === 'BR') {
                run = null;
                return;
            }
            if (node.nodeType === 3 && !node.nodeValue.trim() && !run) return;
            if (!run) {
                run = doc.createElement('p');
                result.appendChild(run);
            }
            run.appendChild(node);
        });

        return result.innerHTML;
    },

    textToHtml: function (text) {
        var escape = function (s) {
            return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        };
        return String(text || '')
            .replace(/\r\n?/g, '\n')
            .split(/\n{2,}/)
            .map(function (block) { return block.trim(); })
            .filter(Boolean)
            .map(function (block) { return '<p>' + escape(block).replace(/\n/g, '<br>') + '</p>'; })
            .join('');
    },

    organizar: function (editorId) {
        var self = this;
        var $el = $('#' + (editorId || 'corpo'));
        var aplicar = function () {
            var antes = $el.summernote('code');
            $el.summernote('code', self.cleanHtml(antes));
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Texto organizado',
                    text: 'Fontes, cores e tamanhos colados foram removidos. Revise títulos e negritos antes de salvar.',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Desfazer'
                }).then(function (result) {
                    if (result.dismiss === 'cancel') {
                        $el.summernote('code', antes);
                    }
                });
            }
        };

        if (window.Swal) {
            Swal.fire({
                icon: 'question',
                title: 'Organizar texto?',
                html: 'Remove fontes, cores e tamanhos que vieram de outros sites/documentos e padroniza parágrafos e títulos.<br><small>Negrito, itálico, links, listas e imagens são mantidos.</small>',
                showCancelButton: true,
                confirmButtonText: 'Organizar',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.isConfirmed || result.value) aplicar();
            });
        } else if (window.confirm('Organizar texto? Fontes, cores e tamanhos colados serão removidos.')) {
            aplicar();
        }
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

        var OrganizarButton = function (context) {
            var ui = $.summernote.ui;
            return ui.button({
                contents: '<i class="fa fa-magic"></i> Organizar texto',
                tooltip: 'Remove formatação colada e padroniza parágrafos e títulos',
                click: function () {
                    self.organizar(editorId || 'corpo');
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
                ['tools', ['organizar']],
                ['view', ['fullscreen', 'codeview', 'undo', 'redo']]
            ],
            buttons: { galeria: GaleriaButton, organizar: OrganizarButton },
            styleTags: ['p', 'h2', 'h3', 'h4', 'blockquote'],
            callbacks: {
                onInit: function () {
                    var editable = $el.next('.note-editor').find('.note-editable').get(0);
                    self.normalizeFontSizes(editable);
                    $el.val($el.summernote('code'));
                    // Garante unidade px no estado do editor
                    try { $el.summernote('fontSizeUnit', 'px'); } catch (e) {}
                },
                onPaste: function (e) {
                    var clipboard = (e.originalEvent || e).clipboardData;
                    var editable = $el.next('.note-editor').find('.note-editable').get(0);

                    if (!clipboard || $el.summernote('codeview.isActivated')) {
                        setTimeout(function () { self.normalizeFontSizes(editable); }, 0);
                        return;
                    }

                    var html = clipboard.getData('text/html');
                    var text = clipboard.getData('text/plain');
                    if (!html && !text) {
                        // Imagens coladas: mantém o comportamento padrão do Summernote
                        return;
                    }

                    e.preventDefault();
                    var limpo = html ? self.cleanHtml(html) : self.textToHtml(text);
                    if (limpo) {
                        $el.summernote('pasteHTML', limpo);
                    }
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
