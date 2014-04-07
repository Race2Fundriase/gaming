jQuery(document).ready(function($) {
    var index = 0;    
    
    $("#tab_control li a").bind("click", function(e){
    
    $("#tab_control li a").each(function() {
        $(this).removeClass("btn-blue")
    });
    
    $(this).addClass("btn-blue");
    
    index = $(this).parent().index();
    
    $(".tabbed_content").each(function(i) {
        $(this).removeClass("active");
        
        if (i == index) {
            $(this).addClass("active");
        }
        });
    
       e.preventDefault(); 
    });
    
    
});