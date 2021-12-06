<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
?>
<!-- <h2 class="title-qak-text"><?php echo $title_docs_api_auth_text; ?> - <?php echo $string_api_title_auth_in; ?></h2>
<h2 class="subtitle-qak-text"><?php echo $subtitle_docs_api; ?></h2>
-->

<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>

<a href="#in"><?php echo $string_api_title_auth_in; ?></a>
<a href="#up"><?php echo $string_api_title_auth_up; ?></a>
<a href="#restore-pass"><?php echo $string_api_title_auth_secure_restore_pass; ?></a>

<h2 class="qak-title-doc" id="in"><?php echo $string_api_title_auth_in; ?></h2>
<!-- <h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_1; ?></h2> -->
<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_2; ?></h2>

<h5 onclick="openHideContent('qak-container-api-js-twoa')"><?php echo $string_api_type_lang_js; ?><a target="_blank" href="https://api.jquery.com/jquery.ajax/">Ajax</a><?php echo $string_api_type_old; ?><l style="width: 100%;"></l><b>-></b></h5>
<qak-container-api id="qak-container-api-js-twoa" style="display: none;">
	<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_3; ?></h2>
	<pre class="prettyprint language-js" style="border: none;">
	$.ajax({type: "POST", url: "<?php echo $default_api; ?>/auth/in", data: {login: "test", password: "1234", code: 1234}, success: function(result) {
			var jsonOBJ = JSON.parse(result);
			if (jsonOBJ['task'] == 'auth:in:success-email') {
				// Требуется код авторизации для получения токена.
				// Отправляем полученный код - через этот же метод с заполненным полем "code" и проводим проверку.
				if (jsonOBJ['type'] == 'success' || jsonOBJ['token'] != null) {
					console.log(jsonOBJ['token']);
					alert('Авторизация прошла успешно!');
				}
			} else {
				// Код не требуется, проходим авторизацию и получаем токен.
				// Проводим проверку.
				if (jsonOBJ['type'] == 'success') {
					console.log(jsonOBJ['token']);
					alert('Авторизация прошла успешно!');
				}
			}
			console.log(result);
		}
	});
	</pre>
</qak-container-api>

<h5 onclick="openHideContent('qak-container-api-js-oauth')">OAuth<l style="width: 100%;"></l><b>-></b></h5>
<qak-container-api id="qak-container-api-js-oauth" style="display: none;">
	<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_oauth_js_2; ?></h2>
	

	<h5 onclick="openHideContent('qak-container-api-js-oauth-at')"><?php echo $string_api_type_lang_js; ?><a target="_blank" href="https://api.jquery.com/jquery.ajax/">Ajax</a><?php echo $string_api_title_oauth_check_access_token; ?><l style="width: 100%;"></l><b>-></b></h5>
	<qak-container-api id="qak-container-api-js-oauth-at" style="display: none;">
		<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_2; ?></h2>
		<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_oauth_js_3; ?></h2>
		<pre class="prettyprint language-js" style="border: none;">
		$.ajax({type: "POST", url: "<?php echo $default_api; ?>/oauth/access-token", data: {access_token: "token", id: 1}, success: function(result) {
				var jsonOBJ = JSON.parse(result);
				if (jsonOBJ['type'] == 'success') {
					alert('Токен действителен, можно продолжать!');
					return;
				} if (jsonOBJ['type'] == 'error') {
					alert('Токен не действителен, запрещаем дальнейшую авторизацию!');
				}
				console.log(result);
			}
		});
		</pre>
	</qak-container-api>
</qak-container-api>

<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_4; ?></h2>
<pre class="prettyprint language-json" style="border: none;">
{
	"id":"id_auth_in_success",
	"type":"success",
	"task":"auth:in:success",
	"camp":"auth",
	"message":"Вы успешно вошли!",
	"token":"****************************",
	"time":"<?php echo date("Y"); ?>-06-05 00:00:00"
}
</pre>
<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_5; ?></h2>
<pre class="prettyprint language-json" style="border: none;">
{
	"id":"id_auth_in_error",
	"type":"error",
	"task":"auth:in:error",
	"camp":"auth",
	"message":"****************************",
	"error_value":"Error value",
	"time":"<?php echo date("Y"); ?>-06-05 00:00:00"
}
</pre>
<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_6; ?></h2>
<pre class="prettyprint language-json" style="border: none;">
{
	"id":"id_auth_in_success_email",
	"type":"success",
	"task":"auth:in:success-email",
	"camp":"auth",
	"message":"На почту \"*******\" было отправлено письмо с кодом!",
	"token":null,
	"time":"<?php echo date("Y"); ?>-06-05 00:00:00"
}
</pre>

<hr>

<h2 class="qak-title-doc" id="up"><?php echo $string_api_title_auth_up; ?></h2>
<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_up_js_1; ?></h2>
<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_up_js_2; ?></h2>

<h5 onclick="openHideContent('qak-container-api-js-up')"><?php echo $string_api_type_lang_js; ?><a target="_blank" href="https://api.jquery.com/jquery.ajax/">Ajax</a><?php echo $string_api_type_old; ?><l style="width: 100%;"></l><b>-></b></h5>
<qak-container-api id="qak-container-api-js-up" style="display: none;">
	<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_up_js_3; ?></h2>
	<pre class="prettyprint language-js" style="border: none;">
	$.ajax({type: "POST", url: "<?php echo $default_api; ?>/auth/up", data: {login: "test", name: "Name", password: "1234"}, success: function(result) {
			var jsonOBJ = JSON.parse(result);
			// Проводим проверку.
			if (jsonOBJ['type'] == 'success') {
				// Регистрация прошла успешно.
				// Получаем token нового пользователя.
				console.log(jsonOBJ['token']);
				alert('Регистрация прошла успешно!');
				return;
			} if (jsonOBJ['type'] == 'error') {
				// Ошибка при регистрации.
				// Выводим сообщение с ошибкой.
				alert(jsonOBJ['message']);
			}
			console.log(result);
		}
	});
	</pre>
</qak-container-api>

<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_4; ?></h2>
<pre class="prettyprint language-json" style="border: none;">
{
	"id":"id_auth_up_success",
	"type":"success",
	"task":"auth:up:success",
	"camp":"auth",
	"message":"Регистрация прошла успешно!",
	"token":"****************************",
	"time":"<?php echo date("Y"); ?>-06-05 00:00:00"
}
</pre>
<h2 class="qak-subtitle-doc"><?php echo $string_api_subtitle_auth_in_js_5; ?></h2>
<pre class="prettyprint language-json" style="border: none;">
{
	"id":"id_auth_up_error",
	"type":"error",
	"task":"auth:up:error",
	"camp":"user",
	"message":"**********************",
	"error_value":"Error value",
	"time":"<?php echo date("Y"); ?>-06-05 00:00:00"
}
</pre>

<hr>

<h2 class="qak-title-doc" id="restore-pass"><?php echo $string_api_title_auth_secure_restore_pass; ?></h2>
<h2 class="qak-subtitle-doc"><?php echo $string_api_message_no_api; ?></h2>