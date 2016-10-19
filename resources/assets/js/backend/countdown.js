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