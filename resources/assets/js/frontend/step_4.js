$(document).ready(function () {
    var $summ = $('#sum');
    var $sumWnd = $('#sumWnd');

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
        var $inputs = $('.option-radio .checkin');

        var summ = parseFloat($summ.data('sum'));
        for (var i = 0; i < $inputs.length; i++) {
            if ($inputs.eq(i).prop('checked')) {
                price = parseFloat($inputs.eq(i).parent().find('label').data('price'));
                summ = summ+price;
            }
        }

        $summ.text(helperPrice(summ));
        $sumWnd.text(helperPrice(summ));
    }

    $('.option-radio input:radio').bind('change', function () {
        reSumm();
    });
});