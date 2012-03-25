<?php /* Smarty version 2.6.26, created on 2012-03-23 11:10:54
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index.tpl', 16, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/message.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2>Ultimele logari</h2>
<table>
	<tr>
		<th>Username</th>
		<th style="width:200px;">IP</th>
		<th style="width:200px;">Data</th>
	</tr>
	<?php $_from = $this->_tpl_vars['userLog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['userLog'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['userLog']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['userLog']['iteration']++;
?>
	<tr>
		<td><?php echo $this->_tpl_vars['item']['username']; ?>
</td>
		<td><?php echo $this->_tpl_vars['item']['ip']; ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d %b %Y, %H:%M") : smarty_modifier_date_format($_tmp, "%d %b %Y, %H:%M")); ?>
</td>
	</tr>
	<?php endforeach; else: ?>
	<tr>
		<td colspan="3">Nu exista nici o intrare</td>
	</tr>
	<?php endif; unset($_from); ?>
</table>
<br />
<div class="note">Apasati tasta "F8" pentru setarea tabelurilor</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>