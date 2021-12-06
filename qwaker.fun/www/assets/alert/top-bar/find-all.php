<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$typeFIND = trim(strval($_GET['tf']));
?>
<ol class="popup bar-top-alert find-users" id="bar-top-alert" onclick="event.stopPropagation()">
	<input id="find-users">
	<!-- <hr> -->
	<ul class="tablayout-qak find">
		<li id="it-users" onclick="changeFind('users')"><?php echo $string['action_find_users']; ?></li>
	</ul>
	<div class="content-find-users" id="content-find-users">
		<h2 class="message-find-users"><?php echo $string['message_please_wait']; ?></h2>
	</div>

	<script type="text/javascript">
		function loadUsers(text, limit) {
			document.getElementById('content-find-users').style.opacity = '.5';
			$.ajax({type: "GET", url: "/assets/content/list-find-users.php", data: {text: text, limit: limit}, success: function(result) {
					$("#content-find-users").empty();
					$("#content-find-users").append(result);
					document.getElementById('content-find-users').style.opacity = '1';
				}
			});
		}

		function changeFind(argument) {
			document.getElementById('it-users').classList.remove('active');
			if (argument == 'users') {
				loadUsers('', 20);
				document.getElementById('find-users').setAttribute('oninput', 'loadUsers(this.value, 20)');
				document.getElementById('find-users').setAttribute('placeholder', stringOBJ['hint_find_users_enter']);
				document.getElementById('it-users').classList.add('active');
			}
		}

		changeFind('users');

		document.getElementById('find-users').focus();
	</script>
</ol>