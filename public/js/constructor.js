var headLine = new Vue({
    el: "#headLine",
    data: {
        summ: 0,
        isStepAddress: true,
        isStepRooms: false,
        isStepBathrooms: false,
        isStepOptions: false,
        isStepOrder: false,
    },
    computed: {
        numberFormat: function () {
            var tmp = this.summ;
            tmp = ''+tmp;
            tmp = tmp.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
            return tmp;
        }
    },
    methods: {
        //роутер по приложению
        next: function (event) {
            if (this.isStepOrder) {
               // метод завершающий регистрацию заявки
            }

            if (this.isStepOptions) {
                //метод отправляющий данные об опциях
                if (sendOptions()) {
                    this.isStepOptions = false;
                    this.isStepOrder = true;
                }
            }

            if (this.isStepBathrooms) {
                // метод отправляющий данные о ванных комнатах
                if (sendBathrooms()) {
                    this.isStepBathrooms = false;
                    this.isStepOptions = true;
                }
            }

            if (this.isStepRooms) {
                // метод отправляющий данные о комнатах
                if (sendRooms()) {
                    this.isStepRooms = false;
                    this.isStepBathrooms = true;
                }
            }

            if (this.isStepAddress) {
                // метод отправляющий данные об адресе
                if (sendAddress()) {
                    this.isStepAddress = false;
                    this.isStepRooms = true;
                }
            }
        }
    }
});

var initAddress = function () {
    var $typesAppartments = $('.constructor_type-apartments');
    $typesAppartments.find('input:checked').parent().addClass('active');
    $typesAppartments.find('input').bind('change', function () {
        if ($(this).prop('checked')) {
            $typesAppartments.removeClass('active');
            $(this).parent().addClass('active');
        }
    });

    var $apartments_square = $('.constructor_type-apartments-square');
    $apartments_square.bind('change', function () {
        var amount = $(this).val();
        if (isNaN(parseInt(amount))) {
            $(this).val('');
        }
    });

    var $variableAmounts = $('[data-toggle="variable_param_checkbox"]').find('input').bind('change', function () {
        var min = $(this).data('min');
        var max = $(this).data('max');
        
        var  val = parseInt($(this).val());
        if (!isNaN(val)) {
            $(this).val(val);
            if (val < min || val > max) {
                $(this).val('');
            }
        } else {
            $(this).val('');
        }
    });
};

var templateMediaObject = "<label class='constructor-mediaObject'>" +
                                "<img src=''>" +
                                "<div>" +
                                    "<input type='radio' name='room' value=''> " +
                                    "<span></span>" +
                                    "<span class='constructor-mediaObject__name'></span> " +
                                    "<span class='constructor-mediaObject__price'></span>" +
                                "</div>" +
                                "<div class='constructor-mediaObject__total'><span>Сумма за ремонт: </span> <span class='total'></span></div>" +
                                "<div class='constructor-mediaObject__description'></div>" +
                          "</label>";

var templateOptions = "<div class='option-item'>" +
                        "<div class='option-name'>{{name}}</div>" +
                        "<div class='option-radio'>" +
                            "<div class='cost-option' id='win_ch'><span>{{summ_formated}}</span><span> р</span></div>" +
                            " <div>" +
                                "<input id='option{{id}}on' class='checkin' type='radio' name='option{{id}}' value='{{id}}'>" +
                                "<label data-price='{{summ}}' for='option{{id}}on'>Да</label>" +
                            "</div>" +
                            "<div>" +
                                "<input id='option{{id}}off' class='uncheck' type='radio' name='option{{id}}'>" +
                                "<label for='option{{id}}off'>Нет</label>" +
                            "</div>" +
                        "</div>" +
                        "<div class='clearbox'></div>" +
                      "</div>";

function numberFormat (number) {
    number = ''+number;
    number = number.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    return number;
}

var initRooms = function () {
    var $rooms = $('.constructor-mediaObject');
    $rooms.bind('click', function () {
        var design_price = $(this).data('design_price');
        var price = $(this).data('price');
        headLine.summ = parseFloat(design_price)+parseFloat(price);
    });
};

var initOptions = function () {
    $('.addition_option .checkin').bind('change', function () {
        var price = parseFloat($(this).parent().find('label').data('price'));

        var summ = parseFloat($('#sum').data('price'));
        if ($(this).prop('checked')) {
            headLine.summ = headLine.summ + price;
            $('#sum').text(numberFormat(price + summ)).data('price', price + summ);
            $(this).parent().parent().data('added', true);
        }
    });

    $('.addition_option .uncheck').bind('change', function() {
        if ($(this).prop('checked') && $(this).parent().parent().data('added')) {
            var price = $(this).parent().parent().find('.checkin').parent().find('label').data('price');
            var summ = parseFloat($('#sum').data('price'));
            headLine.summ = headLine.summ - price;
            $('#sum').text(numberFormat(summ - price)).data('price', summ - price);
        }
    });

};

var sendContacts = function () {
    var email = $('[name="email"]').val();
    var phone = $('[name="phone"]').val();

    if (!email) {
        $('#finalForm [name="email"]').parent().addClass('constructor-hasError');
    }

    if (!phone) {
        $('#finalForm [name="phone"]').parent().addClass('constructor-hasError');
    }

    if ($('#finalForm .constructor-hasError').length > 0) {
        return false;
    }

    $('#addressForm .constructor-hasError').find('input').bind('focus', function () {
        $(this).parent().removeClass('constructor-hasError');
    });

    var hash = $('#addressForm').data('hash');
    $.ajax({
        url: "/constructor/contacts",
        type: 'POST',
        data: '_token=' + hash + '&email=' + email + '&phone=' + phone,
        success: function (data) {
            window.location.pathname = '/';
        },
        error: function () {
            window.location.pathname = '/';
        }
    });

    return true;
};

var sendOptions = function () {
    var data = $('#options form').serialize();
    var hash = $('#addressForm').data('hash');
    $.ajax({
        url: '/constructor/options',
        type: 'POST',
        data: '_token=' + hash + '&' + data,
        success: function (data) {
            if (data.success) {
                $('#options').remove();
                headLine.summ = parseFloat(data.design_price);
                $('#sumWnd').text(numberFormat(data.design_price));
                $('#finalForm').css('display', 'block');
                $('#finalForm .final_form').css('display', 'block');
                $('#finalForm button').bind('click', function () {
                    if (sendContacts()) {
                        $(this).unbind('click');
                    }
                    return false;
                });
            } else {
                window.location.reload();
            }
        },
        error: function () {
            window.location.reload();
        }
    });

    return true;
};

var sendBathrooms = function () {
    var bathroom = $('[name="room"]:checked').val();
    if (!bathroom) return false;
    var hash = $('#addressForm').data('hash');
    $.ajax({
        url: '/constructor/bathrooms',
        type: 'POST',
        data: '_token=' + hash + '&bathroom=' + bathroom,
        success: function (data) {
            if (data.success) {
                $('#bathrooms').remove();
                headLine.summ = parseFloat(data.design_price);
                for (var i = 0; i < data.options.length; i++) {
                    var $option = templateOptions.replace(/{{name}}/g, data.options[i].name);
                    $option = $option.replace(/{{id}}/g, data.options[i].id);
                    $option = $option.replace(/{{summ}}/g, data.options[i].price);
                    $option = $option.replace(/{{summ_formated}}/g, data.options[i].price_formated);
                    $option = $($option);
                    $('#options form').append($option);
                }
                $('#sum').text(data.design_price).data('price', data.design_price);
                $('#options').css('display', 'block');
                initOptions();
            } else {
                window.location.reload();
            }
        },
        error: function() {
            window.location.reload();
        }
    });

    return true;
};

var sendRooms = function () {
    var room = $('[name="room"]:checked').val();
    if (!room) return false;

    var hash = $('#addressForm').data('hash');
    $.ajax({
        url: '/constructor/rooms',
        type: 'POST',
        data: '_token=' + hash + '&room=' + room,
        success: function (data) {
            if (data.success) {
                $('#rooms').remove();
                //выведем блоки
                for (var i = 0; i < data.bathrooms.length; i++) {
                    var $bathroom = $(templateMediaObject);
                    $bathroom.find('img').attr('src', data.bathrooms[i].img);
                    $bathroom.find('input').attr('value', data.bathrooms[i].id);
                    $bathroom.find('.constructor-mediaObject__name').text(data.bathrooms[i].name);
                    if (data.bathrooms[i].price > 0) {
                        $bathroom.find('.constructor-mediaObject__price').text('+ ' + data.bathrooms[i].price + ' р.');
                    }
                    $bathroom.find('.constructor-mediaObject__description').text(data.bathrooms[i].description);
                    $bathroom.data('design_price', data.bathrooms[i].design_price);
                    $bathroom.data('price', data.bathrooms[i].price);
                    $bathroom.find('.constructor-mediaObject__total span').remove();
                    $('#bathrooms').append($bathroom);
                }
                $('#bathrooms').css('display', 'block');
                //блок инициализации выбора комнаты
                initRooms();
            } else {
                window.location.reload();
            }
        },
        error: function () {
            window.location.reload();
        }
    });
    return true;
};

var sendAddress = function () {
    //проверка формы на ввод данных
    var $square = $('#addressForm [name="apartments_square"]');
    if ($square.val() == '') {
        $square.parent().addClass('constructor-hasError');
    }
    var $typeBuilding = $('#addressForm [name="type_building_id"]');
    if (!$typeBuilding.val()) {
        $typeBuilding.parent().addClass('constructor-hasError');
    }
    var $typeBathroom = $('#addressForm [name="type_bathroom_id"]');
    if (!$typeBathroom.val()) {
        $typeBathroom.parent().addClass('constructor-hasError');
    }

    $('#addressForm .constructor-hasError').find('input, select').bind('focus', function () {
        $(this).parent().removeClass('constructor-hasError');
    });

    if ($('#addressForm .constructor-hasError').length === 0) {
        //отправляем форму
        var hash = $('#addressForm').data('hash');
        var $form = $('<form></form>').append($('#addressForm > *'));
        $('#addressForm').append($form);
        var data = $('#addressForm form').serialize();

        $.ajax({
            url: '/constructor/address',
            type: 'POST',
            data: '_token=' + hash + '&' + data,
            success: function (data) {
                if (data.success) {
                    $('#addressForm').css('display', 'none');
                    //выведем блоки
                    for (var i = 0; i < data.rooms.length; i++) {
                        var $room = $(templateMediaObject);
                        $room.find('img').attr('src', data.rooms[i].img);
                        $room.find('input').attr('value', data.rooms[i].id);
                        $room.find('.constructor-mediaObject__name').text(data.rooms[i].name);
                        if (data.rooms[i].price > 0) {
                            $room.find('.constructor-mediaObject__price').text('+ ' + numberFormat(data.rooms[i].price) + ' р.');
                        }
                        $room.find('.constructor-mediaObject__description').text(data.rooms[i].description);
                        $room.find('.constructor-mediaObject__total > span.total').text(numberFormat(data.rooms[i].design_price) + 'р.');
                        $room.data('design_price', data.rooms[i].design_price);
                        $room.data('price', data.rooms[i].price);
                        $('#rooms').append($room);
                    }
                    $('#rooms').css('display', 'block');
                    //блок инициализации выбора комнаты
                    initRooms();
                } else {
                    window.location.reload();
                }
            },
            error: function () {
                window.location.reload();
            }
        });
        return true;
    }

    return false;
};

$(document).ready(function () {
    initAddress();
});