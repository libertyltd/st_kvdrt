jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');

        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();

        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();
    });
    
    
    $(".btn_cons").click(function() {
       $(this).toggleClass("rotation"); 
    });
    
    
    $("#add_cont").click(function() {
      if ($(".final_form").is(":visible")) {
       $(".final_form").fadeOut(600);
      } else {
       $(".final_form").fadeIn(600);
      };
     });
    
    $("#final_close").click(function() {
      $(".final_form").fadeOut(600);
     });
    
    
    $("#radio2").click(function() {
        $("#win_ch span").css('color',"rgba(57, 86, 116, 0.4)");
    });
    $("#radio1").click(function() {
        $("#win_ch span").css('color',"#395674");
    });
    
    $("#radio4").click(function() {
        $("#en_d span").css('color',"rgba(57, 86, 116, 0.4)");
    });
    $("#radio3").click(function() {
        $("#en_d span").css('color',"#395674");
    });
    
    $("#radio6").click(function() {
        $("#ch_rad span").css('color',"rgba(57, 86, 116, 0.4)");
    });
    $("#radio5").click(function() {
        $("#ch_rad span").css('color',"#395674");
    });
    
    $("#radio8").click(function() {
        $("#wr_fl span").css('color',"rgba(57, 86, 116, 0.4)");
    });
    $("#radio7").click(function() {
        $("#wr_fl span").css('color',"#395674");
    });
    
    $("#radio10").click(function() {
        $("#wm_fl span").css('color',"rgba(57, 86, 116, 0.4)");
    });
    $("#radio9").click(function() {
        $("#wm_fl span").css('color',"#395674");
    });
    
    $("#radio12").click(function() {
        $("#dem span").css('color',"rgba(57, 86, 116, 0.4)");
    });
    $("#radio11").click(function() {
        $("#dem span").css('color',"#395674");
    });
});


