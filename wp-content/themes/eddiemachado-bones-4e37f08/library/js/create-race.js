jQuery(document).ready(function($) {
    var index = 0;
    
    //Tab Control
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
    
    $(".optionselect").each(function() {
        $(this).removeClass("active")
        
    });
    
    //Make first visible vehicle active
    $(".optionselect:visible").eq(0).addClass("active");
    
       var selection = $(this).data('selection');
       
       $("input[name=token]:visible").val(selection);
       
       e.preventDefault(); 
    });
    
    //Vehcle selection
    $(".optionselect").bind("click", function(e) {
        
        $(".optionselect").each(function() {
            $(this).removeClass("active")
        });
        
        $(this).addClass("active");
        
        var selection = $(this).data('selection');
        
        $("input[name=token]").val(selection);
        
        e.preventDefault();
    });    
});