<!DOCTYPE html>
<html>
<head>
<title>Login - Interfata de administrare</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{$adminURL}template/css/style.css" />
<script type="text/javascript" src="{$adminURL}template/js/jquery.js"></script>
<script type="text/javascript">
{literal}
	$(document).ready(function() {
		$('#username').focus();
	});
{/literal}
</script>
<base href="{$adminURL}">
</head>
<body>
<div class="login-main">
	<div id="login">
		<div class="top"></div>
		<div class="indent">
			<h2>Admin login</h2>
			{include file="parts/message.tpl"}
			<form action="account/do_login/" method="post">
				<div>
					<label for="username">Username</label>
					<input type="text" name="username" id="username">
				</div>
				<div>
					<label for="password">Parola</label>
					<input type="password" name="password" id="password">
				</div>
				<div>
					<input type="submit" value="Log in">
				</div>
			</form>
		</div>
		<div class="bottom"></div>
	</div>
</div>
</body>
</html>