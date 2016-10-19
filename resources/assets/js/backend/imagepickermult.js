+function ($) {
    'use strict';

    var ImagePickerMultItem = function ($pathToImage, $template, $pathToOrig) {
        var template = '<div class="imagepickermult__item">'+
                            '<div class="imagepickermult__item__container">'+
                                '<img>'+
                                '<span class="imagepickermult__ation-panel">'+
                                    '<button class="imagepickermult__btn imagepickermult__btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                                '</span>'+
                            '</div>'+
                       '</div>';
        var linkTemplate = '<button class="imagepickermult__btn imagepickermult__btn_link" data-original-url=""><i class="fa fa-link" aria-hidden="true"></i></button>';

        this.$elem = $(template);
        this.$elem.find('img').attr('src', $pathToImage);
        var nameOfFile = $pathToImage.split('/');
        nameOfFile = nameOfFile[nameOfFile.length-1];
        this.$elem.find('button.imagepickermult__btn_remove').data('name', nameOfFile);
        if ($pathToOrig) {
            var $btnLink = $(linkTemplate);
            $btnLink.data('content', $pathToOrig);
            $btnLink.attr('title', 'Ссылка на оригинал');
            $btnLink.data('placement', 'right');
            $btnLink.data('container', 'body');
            this.$elem.find('.imagepickermult__ation-panel').append($btnLink);
            $btnLink.popover();
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
            return false;
        });
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
                    new ImagePickerMultItem(images[i], $template, imagesOrig[i]);
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