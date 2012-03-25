<?php /* Smarty version 2.6.26, created on 2012-03-22 16:02:32
         compiled from edit.tpl */ ?>
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

<form action="core/<?php echo $this->_tpl_vars['config']['tableName']; ?>
/" method="post" onsubmit="return checkRequired()" name="editForm">
<table>
	<tr>
		<th colspan="2"><?php echo $this->_tpl_vars['message']['edit']; ?>
</th>
	</tr>
	<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fields'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fields']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['field']):
        $this->_foreach['fields']['iteration']++;
?>
	<tr class="top">
		<td>
			<?php echo $this->_tpl_vars['field']['friendlyName']; ?>

			<?php if ($this->_tpl_vars['field']['required']): ?>
			<span class="highlight">*</span>
			<?php endif; ?>
		</td>
		<td>
			<?php if ($this->_tpl_vars['field']['type'] == 'text'): ?>
			<input type="text" name="<?php echo $this->_tpl_vars['field']['databaseName']; ?>
" value="<?php echo $this->_tpl_vars['field']['value']; ?>
">
			<?php elseif ($this->_tpl_vars['field']['type'] == 'editor'): ?>
			<textarea id="field_<?php echo $this->_tpl_vars['field']['databaseName']; ?>
" name="<?php echo $this->_tpl_vars['field']['databaseName']; ?>
" style="width:460px; height:100px;"><?php echo $this->_tpl_vars['field']['value']; ?>
</textarea>
			<script type="text/javascript"> addTinyMCEEl('field_<?php echo $this->_tpl_vars['field']['databaseName']; ?>
'); </script>
			<?php elseif ($this->_tpl_vars['field']['type'] == 'textarea'): ?>
			<textarea name="<?php echo $this->_tpl_vars['field']['databaseName']; ?>
" style="width:541px; height:100px;"><?php echo $this->_tpl_vars['field']['value']; ?>
</textarea>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['config']['functionVisible']): ?>
	<tr>
		<td style="width:150px;">Visible</td>
		<td><input type="checkbox" name="visible"<?php if ($this->_tpl_vars['item']['visible'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td colspan="2">
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
">
			<input type="hidden" name="act" value="do_edit">
			<input type="submit" value="Submit">
		</td>
	</tr>
</table>
</form>

<script>
<?php echo '
	function checkRequired() {
'; ?>

		var error = '';
		var form  = document.forms.editForm;
		
<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field']):
?>
<?php if ($this->_tpl_vars['field']['required']): ?>
	<?php if ($this->_tpl_vars['field']['type'] == 'editor'): ?>
		if (tinyMCE.get('field_<?php echo $this->_tpl_vars['field']['databaseName']; ?>
').getContent() == '') 
	<?php else: ?>
		if (form.<?php echo $this->_tpl_vars['field']['databaseName']; ?>
.value == '') 
	<?php endif; ?>
			error += 'Campul `<?php echo $this->_tpl_vars['field']['friendlyName']; ?>
` este obligatoriu\n';
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php echo '
		if (error) {
			alert(error.replace(/\\n$/, \'\'));
			return false;
		}
		return true;
	}
'; ?>

</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>