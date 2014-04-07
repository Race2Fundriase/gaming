jQuery(document).ready(function($) {
    var sections = {},
        offset = $('#scrolling-nav').offset().top,
        _height  = $(window).height() - offset,
        i        = 0;
    
    // Grab positions of our sections 
    $('.slide-container').each(function(){
        sections[this.id] = $(this).offset().top;
    });
    
    $(window).resize(function() {
        i = 0;
       // Grab positions of our sections
       $('.slide-container').each(function(){
        sections[this.id] = $(this).offset().top;
    });
       offset = $('#scrolling-nav').offset().top
        _height  = $(window).height() - offset;
    });

    $(document).scroll(function(){
        
      checkNavOffset();
        
        var $this = $(this),
            pos   = $this.scrollTop();
            
        for(i in sections){
            if(sections[i] > pos && sections[i] < pos + _height){
                $('.scrolling-nav-inner ul li').removeClass('highlight');
                $('#nav_' + i).addClass('highlight');
            }  
        }
    });
    
    $('.scrolling-nav-inner ul a').bind('click',function(event){
        var $anchor = $(this);
        
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top-468
        }, 600);
        
        event.preventDefault();
    });
    
    function checkNavOffset() {
    
      if($('#scrolling-nav').offset().top + $('#scrolling-nav').height() >= $('.footer').offset().top-100) {
        $('#scrolling-nav').addClass('stopped');
      }
      
      
     if ($(document).scrollTop() + window.innerHeight < $('.footer').offset().top)
       $('#scrolling-nav').removeClass('stopped'); 
      
    };

});



