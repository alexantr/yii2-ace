if (typeof alexantr === 'undefined' || !alexantr) {
    var alexantr = {};
}

alexantr.aceWidget = (function ($) {
    'use strict';

    var scriptUrl,
        callbacks = [],
        loading = false,
        loaded = false;

    function callPlugin(editorId, textareId, mode, theme, options) {
        var textarea = $('#' + textareId);
        var editor = ace.edit(editorId);
        editor.setTheme('ace/theme/' + theme);
        editor.getSession().setMode('ace/mode/' + mode);
        editor.getSession().setUseWrapMode(true);
        editor.setValue(textarea.val() || '', -1);
        editor.getSession().on('change', function () {
            textarea.val(editor.getSession().getValue()).trigger('change');
        });
        editor.setOptions(options);
    }

    $.getCachedScript = function (url, options) {
        options = $.extend(options || {}, {
            dataType: 'script',
            cache: true,
            url: url
        });
        return $.ajax(options);
    };

    return {
        setScriptUrl: function (url) {
            if (!scriptUrl) {
                scriptUrl = url;
            }
        },
        register: function (editorId, textareId, mode, theme, options) {
            if (loaded) {
                callPlugin(editorId, textareId, mode, theme, options);
            } else {
                callbacks.push({editorId: editorId, textareId: textareId, mode: mode, theme: theme, options: options});
                if (!loading && scriptUrl) {
                    loading = true;
                    $.getCachedScript(scriptUrl).done(function () {
                        loaded = true;
                        loading = false;
                        for (var i = 0; i < callbacks.length; i++) {
                            callPlugin(callbacks[i].editorId, callbacks[i].textareId, callbacks[i].mode, callbacks[i].theme, callbacks[i].options);
                        }
                    });
                }
            }
        }
    }
})(jQuery);
