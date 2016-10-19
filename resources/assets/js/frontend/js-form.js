// JavaScript Document

$(document).ready(function() {
// Форма обратной связи................................./

var regVr22 = "<div><img style='margin-bottom:-4px;' src='/images/load.gif' alt='Отправка...' width='16' height='16'><span style='font: 11px Verdana; color:#395674; margin-left:6px;'>Сообщение обрабатывается...</span></div><br />";

$("#send").click(function(){
		$("#loadBar").html(regVr22).show();
		var posName = $("#posName").val();
		var posEmail = $("#posEmail").val();
		var posText = $("#posText").val();
        var posTheme = $("#posTheme").val();
		$.ajax({
			type: "POST",
			url: "send.php",
			data: {"posName": posName, "posEmail": posEmail, "posText": posText, "posTheme": posTheme,},
			cache: false,
			success: function(response){
		var messageResp = "<p style='' class='green-box'>Спасибо, <strong style='position: relative; top: -3px;'>";
		var resultStat = "!</strong> Ваше сообщение отправлено!</p>";
		var oll = (messageResp + posName + resultStat);
				if(response == 1){
				$("#loadBar").html(oll).fadeIn(3000);
				$("#posName").val("");
				$("#posEmail").val("");
				$("#posText").val("");
                $("#posText").val("");
                $("#posTheme").val("");
				} else {
		$("#loadBar").html(response).fadeIn(3000); }
										}
		});
		return false;
});


});