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
