jQuery(document).ready(function($) {
    $('#main-content label').each(function() {
        text = $(this).text();
        $(this).empty();
        $(this).append('<span>' + text + '</span>');
    })
    
    $('#main-content label').each(function() {
            $(this).next().andSelf().wrapAll('<div>');
    })
    
    /*$('#main-content input').each(function() {
        $(this).unwrap();
        $(this).wrap('<div>');
    })*/
    
    $('#main-content fieldset').wrap('<div class="form-elements">');
    
})