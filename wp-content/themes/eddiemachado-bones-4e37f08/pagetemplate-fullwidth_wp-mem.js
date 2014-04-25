jQuery(document).ready(function($) {
    
    
    $('#main-content label').each(function() {
        text = $(this).text();
        $(this).empty();
        $(this).append('<span>' + text + '</span>');
    })
    
    $('#main-content label').each(function() {
            $(this).next().andSelf().wrapAll('<div>');
    })
    
    $('#main-content fieldset').wrap('<div class="form-elements">');
    
    $content = $('#main-content fieldset');
    $content.replaceWith($content.html());
    
    $('#main-content input[type=submit], #main-content input[type=reset]').addClass('btn large');
})