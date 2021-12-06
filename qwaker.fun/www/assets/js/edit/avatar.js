function updateAvatarAlert() {
	$.ajax({type: "GET", url: "/assets/alert/upd-avatar.php", data: {req: 'ok'}, success: function(result) {
			$('body').append(result);
		}
	});
}