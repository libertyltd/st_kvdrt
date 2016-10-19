/**
 * Created by roman on 10.07.16.
 */
+function ($) {
    'use strict';

    var ImagePickerElem = function (element, option) {
        this.template = '<div class="imagepicker__container">'+
                            '<label class="imagepicker">'+
                                '<div class="imagepicker__hover-place">'+
                                '</div>'+
                                '<div class="imagepicker__action">'+
                                    '<button class="imagepicker__btn imagepicker__btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                                '</div>'+
                            '</label>'+
                        '</div>';
        this.inputClass = 'imagepicker__input';
        this.templateImg = '<img class="imagepicker__miniature img-responsive">';
        this.$element = $(element);

        this.init();

        var self = this;
        this.$element.on('change', function () {
            self.changedImage();
        });

        this.$removeBth.bind('click', function () {
            var nameDeleteInput = self.$element.attr('name');
            var removeImg = self.$element.data('src');
            removeImg = removeImg.replace(/\?\d+/, '');
            self.$template.append('<input type="hidden" name="delete'+nameDeleteInput+'" value="'+removeImg+'">');
            self.$template.find('img').attr('src', '');
            self.$template.find('.imagepicker__action').css({'display': 'none'});
            return false;
        });
    }

    ImagePickerElem.prototype.init = function () {
        this.$element.addClass(this.inputClass);
        var src = this.$element.data('src');
        this.$template = $(this.template);
        this.$element.after(this.$template);
        this.$removeBth  = this.$template.find('button');

        if (src != undefined && src != '') {
            var $img = $(this.templateImg).attr('src', src);
            this.$template.find('.imagepicker__hover-place').append($img);
        } else {
            this.$template.find('.imagepicker__action').css({'display': 'none'});
        }

        this.$template.find('.imagepicker__hover-place').append(this.$element);
    }

    ImagePickerElem.prototype.changedImage = function () {
        if (this.$element[0] && this.$element[0].files[0]) {
            var file = this.$element[0].files[0];
            this.$template.find('.imagepicker__action').css({'display': 'block'});

            var reader = new FileReader();
            var self = this;
            reader.onload = (function (file){
                return function (e) {
                    var $img = self.$template.find('img');
                    if ($img.length == 0) {
                        $img = $(self.templateImg).attr('src', e.target.result);
                        self.$template.find('.imagepicker__hover-place').append($img);
                    } else {
                        self.$template.find('img.imagepicker__miniature').attr('src', e.target.result);
                    }
                    self.$template.find('.imagepicker__hover-place').css({
                        'background':'transparent'
                    });
                };
            })(file);

            reader.readAsDataURL(file);
        }
    }

    var ImagePicker = function (option) {
        return this.each(function () {
            new ImagePickerElem(this, option);
        });
    };

    var old = $.fn.imagepicker;

    $.fn.imagepicker = ImagePicker;
    $.fn.imagepicker.constructor = ImagePicker;

    $.fn.imagepicker.noConflict = function () {
        $.fn.imagepicker = old;
        return this;
    }

}(jQuery);