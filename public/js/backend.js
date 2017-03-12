/**
 * Created by roman on 29.06.16.
 */
$(document).ready(function () {
    /**
     * Инициализация всех тултипов
     */
    $('[data-toggle="tooltip"]').tooltip();
    var $CkEditor = $('[data-toggle="ckeditor"]');
    for (var i = $CkEditor.length; i--;) {
        /* Маленькая инициализационная область для CKEditor */
        var name = $CkEditor.eq(i).attr('name');
        var id = $CkEditor.eq(i).attr('id');

        var errMessage = false;
        if (name == undefined) {
             errMessage = 'Не задан атрибут name!';
        }

        if (id == undefined) {
            errMessage += ' Не задан атрибут id!';
        }

        if (CKEDITOR == undefined) {
            errMessage += 'Не определен CkEditor';
        }

        if (errMessage) {
            errMessage += ' Для элемента '+$CkEditor.eq(i)[0];
            console.log(errMessage);
            continue;
        }

        /* Если же все условия выполнены для замечательной работы CKEditor инициализируем его */
        CKEDITOR.replace(id);
    }


    $('[data-toggle="countdown"]').countdown();
    $('[data-toggle="imagepicker"]').imagepicker();
    $('[data-toggle="imagepickermult"]').imagepickermult();
});
/**
 * Created by roman on 29.06.16.
 */
+function ($) {
    'use strict';

    var CountdownElemForm = function (element, options) {
        this.$element = $(element);
        this.CurrentOption = this.getOptions (options);
        this.$form = this.$element.closest('form');
        this.intervalId = null;
        this.countdownState = 'start';
        this.innerHtml = null;

        var self = this;
        this.$form.bind('submit.countdown', function () {
            return self.sendForm();
        });

        this.$element.bind('click.countdown', function () {
            if (self.countdownState == 'start') {
                self.countdownState = 'proccess';
                self.innerHtml = self.$element.html();
                self.$element.html(self.CurrentOption.countdownTime);
                self.intervalId = setInterval(function () {
                    self.action.call(self);
                }, self.CurrentOption.countdownIntervalSec*1000);
            }

            if (self.countdownState == 'end') {
                return true;
            }
            return false;
        });
    };

    /**
     * Сам непосредственный экшн для отсчета
     */
    CountdownElemForm.prototype.action = function () {
        var time = parseInt(this.$element.html());
        if (time > 0) {
            time--;
            this.$element.html(time);
        } else {
            this.$element.html(this.innerHtml);
            this.countdownState = 'end';
            clearInterval(this.intervalId);
        }
    }

    /**
     * Разршаем отправку формы тогда и только тогда, когда
     * заканчивается обратный отсчет, до этого форму не отрпавляем
     * @returns {boolean}
     */
    CountdownElemForm.prototype.sendForm = function () {
        if (this.countdownState !== 'end') {
            return false;
        }

        return true;
    }

    CountdownElemForm.prototype.options = {
        countdownTime: 3,
        countdownIntervalSec: 1,
    };

    CountdownElemForm.prototype.getOptions = function (options) {
        if (options && (typeof options) == 'Object') {
            for (var key in this.options) {
                if (!options[key]) {
                    options[key] = this.options[key];
                };
            }

            return options;
        }

        return this.options;
    };

    var Countdown = function (options) {
        //вернуть надо объект jQuery
        return this.each(function () {
            new CountdownElemForm(this, options);
        });
    };


    var old = $.fn.countdown;

    $.fn.countdown = Countdown;
    $.fn.countdown.constructor = Countdown;

    $.fn.countdown.noConflict = function () {
        $.fn.countdown = old;
        return this;
    }

}(jQuery);
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

        if (!this.$element.data('nodelete')) {
            this.$removeBth.bind('click', function () {
                var nameDeleteInput = self.$element.attr('name');
                var removeImg = self.$element.data('src');
                removeImg = removeImg.replace(/\?\d+/, '');
                self.$template.append('<input type="hidden" name="'+nameDeleteInput+'[remove]" value="'+removeImg+'">');
                self.$template.find('img').attr('src', '');
                self.$template.find('.imagepicker__action').css({'display': 'none'});
                return false;
            });
        } else {
            this.$template.find('.imagepicker__action').remove();
        }

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
+function ($) {
    'use strict';

    var ImagePickerMultItem = function ($pathToImage, $template, $pathToOrig, target) {
        var template = '<div class="imagepickermult__item">'+
                            '<div class="imagepickermult__item__container">'+
                                '<img>'+
                                '<span class="imagepickermult__ation-panel">'+
                                    '<button class="imagepickermult__btn imagepickermult__btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                                '</span>'+
                            '</div>'+
                       '</div>';
        var linkTemplate = '<button class="imagepickermult__btn imagepickermult__btn_link" data-original-url=""><i class="fa fa-link" aria-hidden="true"></i></button>';

        this.target = target;
        this.targetPath = $pathToOrig;
        this.$elem = $(template);
        this.$elem.find('img').attr('src', $pathToImage);
        var nameOfFile = $pathToImage.split('/');
        nameOfFile = nameOfFile[nameOfFile.length-1];
        this.$elem.find('button.imagepickermult__btn_remove').data('name', nameOfFile);
        if ($pathToOrig && !target) {
            var $btnLink = $(linkTemplate);
            $btnLink.data('content', $pathToOrig);
            $btnLink.attr('title', 'Ссылка на оригинал');
            $btnLink.data('placement', 'right');
            $btnLink.data('container', 'body');
            this.$elem.find('.imagepickermult__ation-panel').append($btnLink);
            $btnLink.popover();
        } else {
            var $btnLink = $(linkTemplate);
            $btnLink.attr('title', 'Вставить в текст');
            this.$elem.find('.imagepickermult__ation-panel').append($btnLink);
        }

        $template.prepend(this.$elem);
        this.$template = $template;

        var self = this;

        /* Тут инициализация действий при нажатии на кнопку */
        this.$elem.find('.imagepickermult__btn_remove').bind('click.imagepickermult', function () {
            self.deleteItem();
            return false;
        });

        this.$elem.find('.imagepickermult__btn_link').bind('click.imagepickermult', function () {
            self.targetLink();
            return false;
        });
    };

    //Вставляет ссылку на изображение в CKEditor
    ImagePickerMultItem.prototype.targetLink = function () {
        if (this.target) {
            $('#cke_'+this.target).find('.cke_button.cke_button__image').click();
            var self = this;
            window.setTimeout(function () {
                $('.cke_editor_'+self.target+'_dialog').find('input').first().val(self.targetPath);
                console.log ($('.cke_edior_'+self.target+'_dialog').find('input'));
            }, 300);
        }
    };

    ImagePickerMultItem.prototype.deleteItem = function () {
        var templateInput = '<input type="hidden">';
        var nameSpace = this.$template.data('namespace');
        nameSpace = nameSpace+'[][remove]';

        var nameOfFile = this.$elem.find('button.imagepickermult__btn_remove').data('name');
        var $InputToRemove = $(templateInput);
        $InputToRemove.attr('name', nameSpace).val(nameOfFile);
        this.$elem.after($InputToRemove);
        this.$elem.remove();
    }

    var ImagePickerAddItem = function ($elem, $template) {
        var addBtnTpl = '<div class="imagepickermult__item add-toggle">'+
                            '<label class="imagepickermult__item__container">'+
                            '</label>'+
                        '</div>';

        this.templateImg = '<div class="imagepickermult__item">'+
                                '<div class="imagepickermult__item__container">'+
                                    '<img>'+
                                    '<span class="imagepickermult__ation-panel">'+
                                        '<button class="imagepickermult__btn imagepickermult__btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                                    '</span>'+
                                '</div>'+
                            '</div>';
        this.deleteInputTmp = '<input type="hidden">';

        $elem.after($template);
        $elem.css({
            'display':'none'
        });

        this.$addBtn = $(addBtnTpl);
        this.$elem = $elem;
        this.$template = $template;

        $template.append(this.$addBtn);

        this.$addBtn.find('label').append($elem);

        var self = this;
        /* Тут инициализация действий при выборе изображения, изображений */
        this.$elem.bind('change', function () {
            self.addSelectedImage();
        });
    };

    ImagePickerAddItem.prototype.addSelectedImage = function () {
        /* Создаем миниатюру */
        /* Перемещаем туда наш $elem */
        /* Помещаем в кнопку добавления клон */
        var files = this.$elem[0].files;

        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            var self = this;
            reader.onload = (function (files){
                return function (e) {
                    console.log (files);
                    var $Image = $(self.templateImg);
                    $Image.find('img').attr('src', e.target.result);
                    $Image.find('.imagepicker__hover-place').css({
                        'background':'transparent'
                    });
                    $Image.data('file-name', files.name);
                    $Image.find('.imagepickermult__btn_remove').bind('click.imagepickermult', function () {
                        var name = $(this).closest('.imagepickermult__item').data('file-name');
                        var nameElem = self.$elem.attr('name')+"[notupload]";
                        var $input = $(self.deleteInputTmp);
                        $input.attr('name', nameElem);
                        $input.val(name);
                        $(this).closest('.imagepickermult__item').after($input);
                        $(this).closest('.imagepickermult__item').remove();

                    });

                    self.$template.find('.add-toggle').before($Image);
                };
            })(files[i]);
            reader.readAsDataURL(files[i]);
        }

    };

    var ImagePickerMult = function (option) {
        return this.each(function () {
            /* тут главный конструктор для элемента this */
            var template = '<div class="imagepickermult__container">'+
                            '</div>';
            var hiddenNamespace = '<input type="hidden">';



            /* Сам элемент в представлении jQuery */
            var $elem = $(this);

            /* Загруженные изображения */
            var images = $elem.data('upload-images');
            images = images.split(',');
            images.pop();

            /* Оригиналы загруженных изображений */
            var imagesOrig = $elem.data('upload-images-orig');
            if (imagesOrig && imagesOrig.length > 0) {
                imagesOrig = imagesOrig.split(',');
                imagesOrig.pop();
            }

            /* Цель связь с CKEditor, будет передаваться в каждую миниатюру */
            var targetCkEditor = $elem.data('target');



            /* Неймспейс в котором храняться изображения */
            var namespace = $elem.attr('id');

            var $template = $(template);
            $template.data('namespace', namespace);
            /*
            var $hiddenInput = $(hiddenNamespace);
            $hiddenInput.attr('name', 'namespace');
            $hiddenInput.val(namespace);
            $template.append($hiddenInput);*/
            /* Создаем кнопку добалвения элементов */
            new ImagePickerAddItem($elem, $template);


            for (var i = 0; i < images.length; i++) {
                if (imagesOrig && imagesOrig[i]) {
                    new ImagePickerMultItem(images[i], $template, imagesOrig[i], targetCkEditor);
                } else {
                    new ImagePickerMultItem(images[i], $template)
                }

            }



        });
    };

    var old = $.fn.imagepickermult;

    $.fn.imagepickermult = ImagePickerMult;
    $.fn.imagepickermult.constructor = ImagePickerMult;

    $.fn.imagepickermult.noConflict = function () {
        $.fn.imagepickermult = old;
        return this;
    }
}(jQuery);
$(document).ready(function () {
    var DesignSwitcher = $('#designs_switcher');
    var $input = DesignSwitcher.find('input[name="design_id"]');
    var $tabsButtons = DesignSwitcher.find('li > a');
    var $tabsBody = DesignSwitcher.find('div.tab-pane');

    $tabsButtons.bind('click', function () {
        $input.val($(this).data('value'));

        var buttons = $tabsBody.find('.btn.btn-default');
        for (var i = 0; i < buttons.length; i++) {
            buttons.eq(i).removeClass('active');
            buttons.eq(i).find('input').prop('checked', false);
        }
    })
});

//# sourceMappingURL=backend.js.map
