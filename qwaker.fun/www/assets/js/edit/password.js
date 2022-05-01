function updatePasswordAlert() {
	showProgressBar();
	$.ajax({type: "GET", url: "/assets/alert/upd-password.php", data: {req: 'ok'}, success: function(result) {
			hideProgressBar();
			$('body').append(result);
		}
	});
}