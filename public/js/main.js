"use strict";

(function($){
    
    $('form button').on('click', function() { 
        var button = $(this);
        var text = button.text();
        button.text('Выполнение...');
        button.prop('disabled', true);
        $.post(
            button.parent('form').attr('action'),
            button.parent('form').serializeArray(),
            function(data) {
                button.closest('.row').find('.result').text(JSON.stringify(data));
            }, 
            'json'
        ).fail(function($xhr) {
            button.closest('.row').find('.result').text('Ошибка! Код:' + $xhr.status);
        }).always(function() {
            button.text(text);
            button.prop('disabled', false);
            $('input[type=password]').val('');
        });
        return false;
    });
    

})(jQuery);