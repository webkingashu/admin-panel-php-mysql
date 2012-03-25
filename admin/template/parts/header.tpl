<!DOCTYPE html>
<html lang="ro">
<head>
<title>Interfata de administrare</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{$adminURL}template/css/style.css" />
<script type="text/javascript">
	var adminURL = '{$adminURL}';
</script>
<script type="text/javascript" src="{$adminURL}template/js/jquery.js"></script>
<script type="text/javascript" src="{$adminURL}template/js/jquery.tools.min.js"></script>
<script type="text/javascript" src="{$adminURL}include/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="{$adminURL}template/js/script.js"></script>
<base href="{$adminURL}">
</head>
<body>
<div class="main">
	<div id="header">
		<div class="indent">
			<div class="alignright">
				Bun venit <a href="account/profile/">{$username}</a> | 
				<a href="account/logout/">Logout</a>
			</div>
			<h1>Interfata de administrare</h1>
		</div>
	</div>