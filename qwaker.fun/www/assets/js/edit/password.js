function updatePasswordAlert() {
	$.ajax({type: "GET", url: "/assets/alert/upd-password.php", data: {req: 'ok'}, success: function(result) {
			$('body').append(result);
		}
	});
}