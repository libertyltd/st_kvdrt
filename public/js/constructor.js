var headLine = new Vue({
    el: "#headLine",
    data: {
        summ: 0,
        isStepAddress: true,
        isStepRooms: false,
        isStepBathrooms: false,
        isStepOptions: false,
        isStepOrder: false,

        selectedRoom: null,
        selectedBathroom: null,
        additionToBathroom: 0,
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
        gotoRooms: function () {
            if (!this.isStepRooms) {
                if (this.selectedRoom) {
                    //проверка на установку выбранного санузла
                    this.isStepBathrooms = false;
                    this.isStepRooms = true;

                    var bathroom = $('[name="room"]:checked').val();
                    headLine.additionToBathroom = parseFloat($('[name="room"]:checked').parent().parent().data('price'));
                    this.selectedBathroom = bathroom;
                    if (!bathroom) {
                        loadRooms();
                        $('#bathrooms').empty().css('display', 'none');
                        return;
                    }
                    var hash = $('#addressForm').data('hash');
                    $.ajax({
                        url: '/constructor/bathrooms',
                        type: 'POST',
                        data: '_token=' + hash + '&bathroom=' + bathroom,
                        success: function (data) {
                            if (!data.success) {
                                window.location.reload();
                            } else {
                                loadRooms();
                                $('#bathrooms').empty().css('display', 'none');
                            }
                        },
                        error: function() {
                            window.location.reload();
                        }
                    });
                }
            }
        },
        gotoBathrooms: function () {
            if (!this.isStepBathrooms) {
                if (this.selectedBathroom) {
                    this.isStepRooms = false;
                    this.isStepBathrooms = true;


                    var room = $('[name="room"]:checked').val();
                    this.selectedRoom = room;
                    if (!room) return false;

                    var hash = $('#addressForm').data('hash');
                    $.ajax({
                        url: '/constructor/rooms',
                        type: 'POST',
                        data: '_token=' + hash + '&room=' + room,
                        success: function (data) {
                            if (!data.success) {
                                window.location.reload();
                            } else {
                                loadBathrooms();
                                $('#rooms').empty().css('display', 'none');
                            }
                        },
                        error: function () {
                            window.location.reload();
                        }
                    });
                }
            }
        },
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

    $('#addressForm button').bind('click', function () {
        $('#controls .btn').click();
        return false;
    });

    $('[data-toggle="variable_param_checkbox"]').each(function () {
        new VariableParamCheckbox(this);
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

var initMediaObjects = function () {
    var $mediaObject = $('.constructor-mediaObject');
    $mediaObject.bind('click', function () {
        var design_price = $(this).data('design_price');
        var price = $(this).data('price');
        headLine.summ = parseFloat(design_price)+parseFloat(price);

        if (headLine.isStepRooms) {
            headLine.summ = parseFloat(headLine.additionToBathroom) + headLine.summ;
        }
    });
};

/**
 * Добавляет медиа-объекты в контейнер
 * @param mediaObjects
 * @param targetSelector
 */
var addMediaObjects = function (mediaObjects, targetSelector) {
    var $container = $(targetSelector);
    for (var i = 0; i < mediaObjects.length; i++) {
        var $mediaObject = $(templateMediaObject);
        $mediaObject.find('img').attr('src', mediaObjects[i].img);
        $mediaObject.find('input').attr('value', mediaObjects[i].id);
        $mediaObject.find('.constructor-mediaObject__name').text(mediaObjects[i].name);
        if (mediaObjects[i].price > 0) {
            $mediaObject.find('.constructor-mediaObject__price').text('+ ' + numberFormat(mediaObjects[i].price) + ' р.');
        }
        $mediaObject.find('.constructor-mediaObject__description').text(mediaObjects[i].description);
        $mediaObject.find('.constructor-mediaObject__total > span.total').text(numberFormat(mediaObjects[i].design_price) + 'р.');
        $mediaObject.data('design_price', mediaObjects[i].design_price);
        $mediaObject.data('price', mediaObjects[i].price);
        $container.append($mediaObject);
    }

    initMediaObjects();
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


var loadOptions = function () {
    $.ajax({
        url: '/constructor/options',
        type: 'GET',
        success: function (data) {
            if (data.success) {
                $('#bathrooms').empty().css('display', 'none');
                headLine.summ = parseFloat(data.design_price);
                headLine.selectedRoom = null;
                headLine.selectedBathroom = null;
                for (var i = 0; i < data.options.length; i++) {
                    var $option = templateOptions.replace(/{{name}}/g, data.options[i].name);
                    $option = $option.replace(/{{id}}/g, data.options[i].id);
                    $option = $option.replace(/{{summ}}/g, data.options[i].price);
                    $option = $option.replace(/{{summ_formated}}/g, data.options[i].price_formated);
                    $option = $($option);
                    $('#options form').append($option);
                }
                $('#sum').text(numberFormat(data.design_price)).data('price', data.design_price);
                $('#options').css('display', 'block');
                initOptions();
            } else {
                window.location.reload();
            }
        },
        error: function () {
            window.location.reload();
        }
    });
}

var sendBathrooms = function (goto) {
    var bathroom = $('[name="room"]:checked').val();
    if (!bathroom) return false;
    var hash = $('#addressForm').data('hash');
    $.ajax({
        url: '/constructor/bathrooms',
        type: 'POST',
        data: '_token=' + hash + '&bathroom=' + bathroom,
        success: function (data) {
            if (data.success) {
                if (!goto) {
                    headLine.selectedBathroom = bathroom;
                    loadOptions();
                }
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


/**
 * Функция загрузки списка ванных комнат
 */
var loadBathrooms = function () {
    $.ajax({
        url: '/constructor/bathrooms',
        type: 'GET',
        success: function(data) {
            if (data.success) {
                $('#rooms').empty().css('display', 'none');
                $('#bathrooms').empty();
                addMediaObjects(data.bathrooms, '#bathrooms');
                if (headLine.selectedBathroom) {
                    $('[value="' + headLine.selectedBathroom + '"]').parent().parent().click();
                }
                $('#bathrooms').css('display', 'block');
            } else {
                window.location.reload();
            }
        },
        error: function () {
            window.location.reload();
        }
    });
};

var sendRooms = function (goto) {
    var room = $('[name="room"]:checked').val();
    if (!room) return false;

    var hash = $('#addressForm').data('hash');
    $.ajax({
        url: '/constructor/rooms',
        type: 'POST',
        data: '_token=' + hash + '&room=' + room,
        success: function (data) {
            if (data.success) {
                if (!goto) {
                    headLine.selectedRoom = room;
                    loadBathrooms();
                }
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

/**
 * Функция загрузки списка дизайна комнат
 */
var loadRooms = function () {
    $.ajax({
        url: '/constructor/rooms',
        type: 'GET',
        success: function(data) {
            if (data.success) {
                $('#addressForm').css('display', 'none');
                $('#rooms').empty();
                //выведем блоки
                addMediaObjects(data.rooms, '#rooms');
                //проинициализируем блок, если он был выбран ранее
                if (headLine.selectedRoom) {
                    $('[value="' + headLine.selectedRoom + '"]').parent().parent().click();
                }
                $('#rooms').css('display', 'block');
            } else {
                window.location.reload();
            }
        },
        error: function() {
            window.location.reload();
        }
    });
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
                    loadRooms();
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