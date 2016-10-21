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