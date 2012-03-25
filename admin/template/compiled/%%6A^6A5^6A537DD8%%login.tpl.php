<?php /* Smarty version 2.6.26, created on 2012-03-17 17:34:17
         compiled from login.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<title>Login - Interfata de administrare</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['adminURL']; ?>
template/css/style.css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['adminURL']; ?>
template/js/jquery.js"></script>
<script type="text/javascript">
<?php echo '
	$(document).ready(function() {
		$(\'#username\').focus();
	});
'; ?>

</script>
<base href="<?php echo $this->_tpl_vars['adminURL']; ?>
">
</head>
<body>
<div class="login-main">
	<div id="login">
		<div class="top"></div>
		<div class="indent">
			<h2>Admin login</h2>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/message.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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