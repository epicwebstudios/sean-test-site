jQuery_defer(function () {

    // does nothing here but is cool to have
    function getScripts(scripts, callback = false) {
        var progress = 0;
        scripts.forEach(function (script) {
            $.getScript(script, function () {
                if (++progress == scripts.length && callback) callback();
            });
        });
    }

    // gets the lazy load scripts and runs callback afterwords
    function get_lazy_scripts(callback) {
        $.getScript('//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js', function() {
            $.getScript('//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js', function() {
                callback();
            });
        });
    }

    // the lazy load
    function do_lazy_load() {
        $('.lazy').Lazy({
            effect:'fadeIn',
            effectTime:500,
            threshold:99999,
            // visibleOnly:true,
            onError:function (element) {
                console.log('error loading ' + element.data('src'));
            }
        });
    }

    $(document).ready(function () {
        get_lazy_scripts(do_lazy_load);
    });

});