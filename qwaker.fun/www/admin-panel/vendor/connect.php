<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/data.php'; ?>
<?php
	$db_host = 'localhost'; // ХОСТ БАЗЫ ДАННЫХ - НАПРИМЕР, localhost
	$db_user = 'root'; // ПОЛЬЗОВАТЕЛЬ ОТ БАЗЫ ДАННЫХ - НАПРИМЕР, root
	$db_password = ''; // ПАРОЛЬ ОТ БАЗЫ ДАННЫХ - НАПРИМЕР, 1234
	$db_name = 'qak'; // ИМЯ БАЗЫ ДАННЫХ - НАПРИМЕР, database

	$connect = mysqli_connect($db_host, $db_user, $db_password, $db_name);

	if ($connect) {} else {
		echo("No connect data base");
		exit();
	}
?>