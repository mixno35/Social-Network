function updateAvatarAlert() {
	showProgressBar();
	$.ajax({type: "GET", url: "/assets/alert/upd-avatar.php", data: {req: 'ok'}, success: function(result) {
			hideProgressBar();
			$('body').append(result);
		}
	});
}