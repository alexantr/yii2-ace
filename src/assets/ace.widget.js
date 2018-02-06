if (typeof alexantr === 'undefined' || !alexantr) {
    var alexantr = {};
}

alexantr.aceWidget = (function (d) {
    return {
        register: function (editorId, textareId, mode, theme, options) {
            var editor = ace.edit(editorId);
            editor.setTheme('ace/theme/' + theme);
            editor.getSession().setMode('ace/mode/' + mode);
            editor.getSession().setUseWrapMode(true);
            editor.setValue(d.getElementById(textareId).value, -1);
            editor.getSession().on('change', function () {
                var textarea = d.getElementById(textareId);
                textarea.value = editor.getSession().getValue();
                if ('createEvent' in d) {
                    var ev = d.createEvent('HTMLEvents');
                    ev.initEvent('change', false, true);
                    textarea.dispatchEvent(ev);
                } else {
                    textarea.fireEvent('onchange');
                }
            });
            editor.setOptions(options);
        }
    }
})(document);
