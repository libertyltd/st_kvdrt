var VariableParamCheckbox = function (element) {
    this.$element = $(element);
    this.$checkbox = this.$element.find('input[type="checkbox"]');
    this.$input = this.$element.find('input[type="text"]');
    this.input_max = this.$input.data('max');
    this.input_min = this.$input.data('min');

    if (isNaN(parseInt(this.input_min))) {
        this.input_min = null;
    }

    if (isNaN(parseInt(this.input_max))) {
        this.input_max = this.input_min;
    }


    var self = this;
    this.$checkbox.bind('change', function () {
        self.handleCheckbox();
    });

    this.$input.bind('click', function (ev) {
        ev.preventDefault();
    });
    this.$input.bind('change', function() {
        self.handleInput();
    });

    this.handleCheckbox();
    this.handleInput();
};

VariableParamCheckbox.prototype.handleInput = function () {
    var value = this.$input.val();
    if (isNaN(parseInt(value))) {
        this.$input.val(this.input_min);
    } else if (!isNaN(parseInt(this.input_min)) && !isNaN(parseInt(this.input_max))) {
        if (value < this.input_min || value > this.input_max) {
            this.$input.val(this.input_min);
        }
    }
};

VariableParamCheckbox.prototype.handleCheckbox = function () {
    if (this.$checkbox.prop('checked')) {
        this.$input.attr('required', 'required');
    } else {
        this.$input.removeAttr('required');
    }
};




jQuery(document).ready(function() {
    $('[data-toggle="variable_param_checkbox"]').each(function () {
        new VariableParamCheckbox(this);
    });

    var finalForm = {
        hide: function() {
            $('body').removeClass('final_form_freeze');
            $(".final_form").fadeOut(600);
        },
        show: function() {
            $('body').addClass('final_form_freeze');
            $(".final_form").fadeIn(600);
        },
    };

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


    $('.add_cont').click(function(e) {
        e.preventDefault();
        if ($('.final_form').is(':visible')) {
            finalForm.hide();
        } else {
            finalForm.show();
        }
    });

    $("#final_close").click(function() {
       finalForm.hide();
    });

    $('[data-toggle="constructor"]').bind('click', function() {
        var idDesign = $(this).data('id');
        $('.final_form').find('form').find('[name="design"]').remove();
        $('.final_form').find('form').append('<input type="hidden" name="design" value="' + idDesign + '">');
        $('.add_cont').first().trigger('click');
        return false;
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

$(document).ready(function () {
    $('.promo_background').addClass('enable');
});


