$(document).ready(function() {
    $('.for_translation').each(function(key) {
        $(this).attr('data-id', key);
    });

    $('.alias').each(function(key) {
        $(this).attr('data-id', key);
    });

    $('.for_translation').on('keyup', function() {
        var for_translation_id = $(this).attr('data-id');
        var transliteration_string = $(this).transliteration();

        $('.alias[data-id="' + for_translation_id + '"]').val(transliteration_string);

        return false;
    });
});

(function( $ ) {
    $.fn.transliteration = function() {
        var value = $(this).val();
        var symbols = {
            'А':'A','а':'a','Б':'B','б':'b','В':'V','в':'v','Г':'G','г':'g',
            'Д':'D','д':'d','Е':'E','е':'e','Ё':'Yo','ё':'yo','Ж':'Zh','ж':'zh',
            'З':'Z','з':'z','И':'I','и':'i','Й':'Y','й':'y','К':'K','к':'k',
            'Л':'L','л':'l','М':'M','м':'m','Н':'N','н':'n','О':'O','о':'o',
            'П':'P','п':'p','Р':'R','р':'r','С':'S','с':'s','Т':'T','т':'t',
            'У':'U','у':'u','Ф':'F','ф':'f','Х':'Kh','х':'kh','Ц':'Ts','ц':'ts',
            'Ч':'Ch','ч':'ch','Ш':'Sh','ш':'sh','Щ':'Sch','щ':'sch','Ъ':'','ъ':'',
            'Ы':'Y','ы':'y','Ь':"",'ь':"",'Э':'E','э':'e','Ю':'Yu','ю':'yu',
            'Я':'Ya','я':'ya',' ':'-','W':'W','w':'w','X':'X','x':'x','Q':'Q','q':'q',
            'J':'J','j':'j',
            '0':'0','1':'1','2':'2','3':'3','4':'4','5':'5','6':'6','8':'8','9':'9'
        }

        var str = new String();
        var en_symbol = [];

        for(key in symbols) en_symbol += symbols[key];

        for(var i = 0; i < value.length; i++) {
            if(typeof(symbols[value[i]]) !== "undefined") {
                str += symbols[value[i]];
            }
            else if(en_symbol.indexOf(value[i]) !== -1) {
                str += value[i];
            }
            else {
                str += "";
            }
        }

        return str.toLowerCase();
    };
})(jQuery);