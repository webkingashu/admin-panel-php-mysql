<?php /* Smarty version 2.6.26, created on 2012-03-22 20:42:21
         compiled from coreSettingsList.tpl */ ?>
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

<form action="tables-settings/" method="post">
<table>
	<tr>
		<th class="center" style="width:20px;"><input type="checkbox" class="sel_all"></th>
		<th><a href="<?php echo $this->_tpl_vars['order']['name']; ?>
">Name <?php echo $this->_tpl_vars['dirOrder']['name']; ?>
</a></th>
		<th class="visible center"><a href="<?php echo $this->_tpl_vars['order']['order']; ?>
">Order <?php echo $this->_tpl_vars['dirOrder']['order']; ?>
</a></th>
		<th class="visible center"><a href="<?php echo $this->_tpl_vars['order']['visible']; ?>
">Visible <?php echo $this->_tpl_vars['dirOrder']['visible']; ?>
</a></th>
		<th class="actions center">Actions</th>
	</tr>
	<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['items'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['items']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['items']['iteration']++;
?>
	<tr>
		<td class="center"><input type="checkbox" class="cb" name="item[<?php echo $this->_tpl_vars['item']['id']; ?>
]"></td>
		<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
		<td class="center"><input class="order" value="<?php echo $this->_tpl_vars['item']['order']; ?>
" type="text" name="order_<?php echo $this->_tpl_vars['item']['id']; ?>
"></td>
		<td class="center">
		  <?php if ($this->_tpl_vars['item']['visible']): ?>
			<img src="template/images/icons/checkmark.png" alt="">
		  <?php else: ?>
			<img src="template/images/icons/delete.png" alt="">
		  <?php endif; ?>
		</td>
		<td class="center">
			<a href="tables-settings/?act=edit&amp;id=<?php echo $this->_tpl_vars['item']['id']; ?>
" title="Editeaza"><img src="template/images/icons/edit.png" alt=""></a>
			<a href="tables-settings/?act=delete&amp;id=<?php echo $this->_tpl_vars['item']['id']; ?>
" onclick="return confirm('Esti sigur ?')" title="Sterge"><img src="template/images/icons/remove.png" alt=""></a>
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr>
		<td colspan="5">Nu exista nici o intrare</td>
	</tr>
	<?php endif; unset($_from); ?>
	<tr>
		<td colspan="5">
			<input type="submit" name="submit" value="Schimba ordinea">
			<input type="submit" name="submit" value="Sterge">
			<input type="hidden" name="act" value="modify">
		</td>
	</tr>
</table>
</form>
<a href="tables-settings/?act=edit" class="add">Adauga un nou tabel</a>
<div class="clear"></div>
<?php echo $this->_tpl_vars['pager']; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>