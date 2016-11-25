$(document).ready(function () {
    /* При клике на лейбу меняем изображения */
    /* Пересчитываем стоимость услуг */
    var $summ = $('#sum');
    var $photoPlace = $('.constructor_images');
    var $labels = $('#optionsForm label');

    function helperPrice(price) {
        var fraction = (price*100)%100;
        price = ''+price;
        var integer = price.split('.');
        integer = integer[0];

        var lengthOfInteger = integer.length;

        if (lengthOfInteger > 0) {
            lengthOfInteger--;
        }

        var row = [];
        var counter = 0;

        for (; lengthOfInteger >= 0; lengthOfInteger--) {
            row.push(integer.charAt(lengthOfInteger));
            counter++;
            if (counter%3 == 0) {
                row.push(' ');
                counter = 0;
            }
        }

        lengthOfInteger = row.length;
        if (lengthOfInteger > 0) {
            lengthOfInteger--;
        }
        integer = '';
        for (; lengthOfInteger >= 0; lengthOfInteger--) {
            integer = integer+row[lengthOfInteger];
        }

        if (fraction > 0) {
            if (fraction < 10) {
                fraction = '0'+fraction;
            }

            integer = integer+','+fraction;
        }

        return integer;
    };

    function reSumm () {
        var $inputs = $('#optionsForm').find('input');

        var summ = parseFloat($summ.data('sum'));
        for (var i = 0; i < $inputs.length; i++) {
            if ($inputs.eq(i).prop('checked')) {
                price = parseFloat($inputs.eq(i).parent().find('label').data('price'));
                summ = summ+price;
            }
        }

        $summ.text(helperPrice(summ));
    }

    $('#optionsForm').find('input').bind('change', function () {
        reSumm();
    });

    $labels.bind('click', function () {
        var hall = $(this).data('hall');
        var bath = $(this).data('bath');


        /**
         * Плавно скрывааем изображения
         */
        $photoPlace.find('.left_img, .right_img').animate({
            opacity: 0,
        }, {
            duration: 300,
            complete: function () {
                $photoPlace.find('.left_img > img').attr('src', hall);
                if (bath === '') {
                    $photoPlace.find('.left_img').addClass('left_img_last');
                    $photoPlace.find('.right_img').addClass('right_img_none');
                } else {
                    $photoPlace.find('.left_img').removeClass('left_img_last');
                    $photoPlace.find('.right_img').removeClass('right_img_none');
                    $photoPlace.find('.right_img > img').attr('src', bath);
                }

                $photoPlace.find('.left_img, .right_img').animate({
                    opacity: 1
                }, {
                    duration: 300,
                });
            },
        });


    });
});