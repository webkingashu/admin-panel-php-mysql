<?php /* Smarty version 2.6.26, created on 2012-03-22 16:02:04
         compiled from list.tpl */ ?>
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

<?php if ($this->_tpl_vars['filters']): ?>
<form action="core/<?php echo $this->_tpl_vars['config']['tableName']; ?>
/" method="post">
<table>
	<tr>
		<th colspan="2">Filtrare</th>
	</tr>
	<?php $_from = $this->_tpl_vars['filters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['filters'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['filters']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['filter']):
        $this->_foreach['filters']['iteration']++;
?>
	<tr>
		<td><?php echo $this->_tpl_vars['filter']['friendlyName']; ?>
</td>
		<td>
			<?php if ($this->_tpl_vars['filter']['type'] == 'text'): ?>
			<input type="text" name="<?php echo $this->_tpl_vars['filter']['databaseName']; ?>
" value="<?php echo $this->_tpl_vars['filter']['value']; ?>
">
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	<tr>
		<td colspan="2">
			<input type="submit" name="submit" value="Filtreaza">
			<input type="submit" name="submit" value="Sterge filtrele">
			<input type="hidden" name="act" value="modify_filters">
		</td>
	</tr>
</table>
</form>
<br>
<?php endif; ?>

<form action="core/<?php echo $this->_tpl_vars['config']['tableName']; ?>
/" method="post">
<table>
	<tr>
		<th class="center" style="width:20px;"><input type="checkbox" class="sel_all"></th>
		<th><a href="<?php echo $this->_tpl_vars['order'][$this->_tpl_vars['config']['displaiedName']]; ?>
"><?php echo $this->_tpl_vars['config']['displaiedFriendlyName']; ?>
 <?php echo $this->_tpl_vars['dirOrder'][$this->_tpl_vars['config']['displaiedName']]; ?>
</a></th>
		<?php if ($this->_tpl_vars['config']['functionSetOrder']): ?><th class="visible center"><a href="<?php echo $this->_tpl_vars['order']['order']; ?>
">Order <?php echo $this->_tpl_vars['dirOrder']['order']; ?>
</a></th><?php endif; ?>
		<?php if ($this->_tpl_vars['config']['functionVisible']): ?><th class="visible center"><a href="<?php echo $this->_tpl_vars['order']['visible']; ?>
">Visible <?php echo $this->_tpl_vars['dirOrder']['visible']; ?>
</a></th><?php endif; ?>
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
		<td><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['config']['displaiedName']]; ?>
</td>
		<?php if ($this->_tpl_vars['config']['functionSetOrder']): ?><td class="center"><input class="order" value="<?php echo $this->_tpl_vars['item']['order']; ?>
" type="text" name="order_<?php echo $this->_tpl_vars['item']['id']; ?>
"></td><?php endif; ?>
		<?php if ($this->_tpl_vars['config']['functionVisible']): ?>
		<td class="center">
		  <?php if ($this->_tpl_vars['item']['visible']): ?>
			<img src="template/images/icons/checkmark.png" alt="">
		  <?php else: ?>
			<img src="template/images/icons/delete.png" alt="">
		  <?php endif; ?>
		</td>
		<?php endif; ?>
		<td class="center">
			<?php if ($this->_tpl_vars['config']['functionEdit']): ?><a href="core/<?php echo $this->_tpl_vars['config']['tableName']; ?>
/?act=edit&amp;id=<?php echo $this->_tpl_vars['item']['id']; ?>
" title="Editeaza"><img src="template/images/icons/edit.png" alt=""></a><?php endif; ?>
			<?php if ($this->_tpl_vars['config']['functionDelete']): ?><a href="core/<?php echo $this->_tpl_vars['config']['tableName']; ?>
/?act=delete&amp;id=<?php echo $this->_tpl_vars['item']['id']; ?>
" onclick="return confirm('Esti sigur ?')" title="Sterge"><img src="template/images/icons/remove.png" alt=""></a><?php endif; ?>
			<?php if ($this->_tpl_vars['config']['functionImages']): ?><a href="#" title="Imagini"><img src="template/images/icons/image.png" alt=""></a><?php endif; ?>
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr>
		<td colspan="<?php echo $this->_tpl_vars['colspan']; ?>
">Nu exista nici o intrare</td>
	</tr>
	<?php endif; unset($_from); ?>
	<tr>
		<td colspan="<?php echo $this->_tpl_vars['colspan']; ?>
">
			<?php if ($this->_tpl_vars['config']['functionSetOrder']): ?><input type="submit" name="submit" value="Schimba ordinea"><?php endif; ?>
			<?php if ($this->_tpl_vars['config']['functionDelete']): ?><input type="submit" name="submit" value="Sterge"><?php endif; ?>
			<input type="hidden" name="act" value="modify">
		</td>
	</tr>
</table>
</form>
<?php if ($this->_tpl_vars['config']['functionAdd']): ?><a href="core/<?php echo $this->_tpl_vars['config']['tableName']; ?>
/?act=edit" class="add"><?php echo $this->_tpl_vars['message']['add']; ?>
</a><?php endif; ?>
<div class="clear"></div>
<?php echo $this->_tpl_vars['pager']; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>