<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php
	function isMobile() {
		if (preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT'])) {
			return true;
		}
		return false;
	}

	function getRangName($value='') {
		if ($value == 2) {
			return "Модератор";
		} if ($value == 3) {
			return "Администратор";
		} if ($value == 4) {
			return "Разработчик";
		}
		return $value;
	}
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Админ-Панель</title>
	<link rel="stylesheet" type="text/css" href="/admin-panel/assets/css/style.css?v=6">
	<script src="/assets/js/jquery/jquery-3.5.0.js"></script>
	<script src="/assets/js/jquery/jquery.min.js"></script>
	<script src="/assets/js/jquery/jquery-ui.min.js"></script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/page/check.php'; ?>

	<header class="bar">
		<div class="menu-left" onclick="openMenuLeft()" title="Нажмите, чтобы открыть боковое меню"></div>
		<h2></h2>
		<div class="user-content" onclick="openPage('index', 0)">
			<h4 class="rang"><?php echo getRangName($dataUSER['rang']); ?>(<?php echo $dataUSER['rang']; ?>)</h4>
			<img src="<?php echo $dataUSER['avatar']; ?>" >
		</div>
	</header>

	<div class="menu-left-overlay" id="menu-left-overlay" style="display: none;" onclick="openMenuLeft()">
		<div class="menu-left-container" onclick="event.stopPropagation()">
			
		</div>
	</div>

	<div class="command-container">
		<input type="command" class="command-input" id="command-input" placeholder="Введите команду, например: /ban 1">
		<button title="Выполнить команду" class="command-inject" onclick="injectCommand(document.getElementById('command-input').value)">Вып.<?php if(isMobile()==false){echo' (Enter)';} ?></button>
	</div>
	<h5 class="command-help" onclick="helpCommand()" title="Нажмите, чтобы получить помощь по командам">Команды</h5>
	<div class="command-help-description" id="command-help-description" style="display: none;">
		<font class="title">Команды для управления пользователями</font>
		<ul id="command-help-cont-users">
			<li><b>/ban [id]</b> - Заблокировать пользователя.(3+)</li>
			<li><b>/unban [id]</b> - Разблокировать пользователя.(3+)</li>
			<li><b>/scam [id]</b> - Выдать пользователю отметку "Скам".(3+)</li>
			<li><b>/unscam [id]</b> - Убрать для пользователя отметку "Скам".</li>
			<li><b>/rang [id] [rang]</b> - Установить пользователю ранг: 1 - пользователь, 2 - модератор, 3 - админ, 4 - разработчик.(4+)</li>
			<li><b>/verification [id] [status]</b> - Выдать(1)/Убрать(0) верификацию.(4+)</li>
			<li><b>/upubpost [id] [status]</b> - Выдать(1)/Убрать(0) возможность публиковать новые публикации.(3+)</li>
			<li><b>/uchatj [id] [status]</b> - Выдать(1)/Убрать(0) возможность присоединяться к чатам.(3+)</li>
			<li><b>/uchatc [id] [status]</b> - Выдать(1)/Убрать(0) возможность создавать чаты.(3+)</li>
		</ul>
		<font class="title">Команды для управления публикациями</font>
		<ul id="command-help-cont-posts">
			<li><b>/type [id] [type]</b> - Изменить тип публикации: post - публикация, ads - реклама.(4+)</li>
			<li><b>/archive [id] [status]</b> - Переместить(1) в архив/Убрать(0) из архива.(2+)</li>
			<li><b>/commented [id] [status]</b> - Разрешить(1)/Запретить(0) оставлять новые комментарии.(2+)</li>
			<li><b>/removepost [id]</b> - Удалить публикацию.(2+)</li>
		</ul>
		<font class="title">Команды для управления комментариями</font>
		<ul id="command-help-cont-comments">
			<li><b>/removecomm [id]</b> - Удалить комментарий.(2+)</li>
		</ul>
		<font class="title">Команды для управления инвайт кодами</font>
		<ul id="command-help-cont-invited">
			<li><b>/createinvite [type]</b> - Создать инвайт код: int - только числовой, str - только буквенный, оставьте тип пустым чтобы создать буквенно-числовой.(4+)</li>
			<li><b>/removeinvite [id]</b> - Удалить инвайт код.(4+)</li>
		</ul>
	</div>

	<div id="index-content-top-menu" class="index-content">
		
	</div>

	<div class="progress-bar">
		<img id="progress-bar" style="display: none;" src="/admin-panel/assets/images/loading-filter-ajax.gif">
	</div>

	<div class="index-content" id="index-content">
		
	</div>

	<script type="text/javascript">
		var command_input = document.getElementById("command-input");
		command_input.addEventListener("keyup", function(event) {
			if (event.keyCode === 13) {
			    event.preventDefault();
			    injectCommand(command_input.value);
			}
		});

		var openedPage = "";
		var limitPage = 0;

		function openMenuLeft() {
			event.stopPropagation();
			if (document.getElementById('menu-left-overlay').style.display == "block") {
				document.getElementById('menu-left-overlay').style.display = "none";
			} else {
				document.getElementById('menu-left-overlay').style.display = "block";
			}
		}

		function injectCommand(argument) {
			if (argument.trim().length < 6) {
				alert('Команда не может быть пустой или содержать менее 6 символов.');
				return;
			}
			$.ajax({
				type: "POST", 
				url: "vendor/api/command.php", 
				data: {command: argument}, 
		    	success: function(result) {
					alert(result);
					openPage(openedPage, limitPage);
				}
			});
		}

		function openPage(argument, argument2) {
			$.ajax({
				type: "POST", 
				url: "page/index.php", 
				data: {limit: argument2}, 
		    	success: function(result) {
		    		openedPage = argument;
					limitPage = argument2;
					$("#index-content-top-menu").empty();
					$("#index-content-top-menu").append(result);
					document.getElementById('index-content-top-menu').style.opacity = '1';
				}
			});
			if (argument == 'index') {
				$("#index-content").empty();
				return;
			}
			document.getElementById('index-content').style.opacity = '.5';
			document.getElementById('index-content-top-menu').style.opacity = '.5';
			document.getElementById('progress-bar').style.display = 'block';
			$.ajax({
				type: "POST", 
				url: "page/" + argument + ".php", 
				data: {limit: argument2}, 
		    	success: function(result) {
		    		openedPage = argument;
					limitPage = argument2;
					$("#index-content").empty();
					$("#index-content").append(result);
					document.getElementById('index-content').style.opacity = '1';
					document.getElementById('progress-bar').style.display = 'none';
				}
			});
		}

		function helpCommand() {
			if (document.getElementById('command-help-description').style.display == 'none') {
				document.getElementById('command-help-description').style.display = 'block';
			} else {
				document.getElementById('command-help-description').style.display = 'none';
			}
			// alert(""+
			// 	"-USERS-------------------------\n"+
			// 	"/ban [id] - Заблокировать пользователя.(3+)\n"+
			// 	"/unban [id] - Разблокировать пользователя.(3+)\n"+
			// 	"/scam [id] - Выдать пользователю отметку \"Скам\".(3+)\n"+
			// 	"/unscam [id] - Убрать для пользователя отметку \"Скам\".\n"+
			// 	"/rang [id] [rang] - Установить пользователю ранг: 1 - пользователь, 2 - модератор, 3 - админ, 4 - разработчик.(4+)\n"+
			// 	"/verification [id] [status] - Выдать(1)/Убрать(0) верификацию.(4+)\n"+
			// 	"/upubpost [id] [status] - Выдать(1)/Убрать(0) возможность публиковать новые публикации.(3+)\n"+
			// 	"/uchatj [id] [status] - Выдать(1)/Убрать(0) возможность присоединяться к чатам.(3+)\n"+
			// 	"/uchatc [id] [status] - Выдать(1)/Убрать(0) возможность создавать чаты.(3+)\n"+
			// "");
		}

		openPage("index", 0);
	</script>
</body>
</html>