<?php /* Smarty version 2.6.26, created on 2012-03-23 09:57:56
         compiled from coreSettingsEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'coreSettingsEdit.tpl', 21, false),)), $this); ?>
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

<form action="tables-settings/" method="post" name="editForm">
<h3>Setari generale</h3>
<table>
	<tr>
		<th colspan="2">Setari afisare</th>
	</tr>
	<tr>
		<td>Nume tabel</td>
		<td><input type="text" name="tableName" value="<?php echo $this->_tpl_vars['config']['tableName']; ?>
"></td>
	</tr>
	<tr>
		<td>Nume pagina</td>
		<td><input type="text" name="pageName" value="<?php echo $this->_tpl_vars['config']['pageName']; ?>
"></td>
	</tr>
	<tr>
		<td>Nume afisat</td>
		<td><input type="text" name="displaiedName" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['config']['displaiedName'])) ? $this->_run_mod_handler('default', true, $_tmp, 'nume') : smarty_modifier_default($_tmp, 'nume')); ?>
"></td>
	</tr>
	<tr>
		<td>Nume friendly afisat</td>
		<td><input type="text" name="displaiedFriendlyName" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['config']['displaiedFriendlyName'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Nume') : smarty_modifier_default($_tmp, 'Nume')); ?>
"></td>
	</tr>
	<tr>
		<td>Limita pe pagina</td>
		<td><input type="text" name="limitPerPage" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['config']['limitPerPage'])) ? $this->_run_mod_handler('default', true, $_tmp, 20) : smarty_modifier_default($_tmp, 20)); ?>
"></td>
	</tr>
	<tr>
		<th colspan="2">Functii</th>
	</tr>
	<tr>
		<td>Adaugare</td>
		<td><input type="checkbox" name="functionAdd"<?php if ($this->_tpl_vars['config']['functionAdd'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Editare</td>
		<td><input type="checkbox" name="functionEdit"<?php if ($this->_tpl_vars['config']['functionEdit'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Stergere</td>
		<td><input type="checkbox" name="functionDelete"<?php if ($this->_tpl_vars['config']['functionDelete'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Seteaza orfinea</td>
		<td><input type="checkbox" name="functionSetOrder"<?php if ($this->_tpl_vars['config']['functionSetOrder'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Vizibil pe site</td>
		<td><input type="checkbox" name="functionVisible"<?php if ($this->_tpl_vars['config']['functionVisible'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Creaza tabel</td>
		<td><input type="checkbox" name="functionCreateTable"<?php if ($this->_tpl_vars['config']['functionCreateTable'] || ! $_GET['id']): ?> checked="checked"<?php endif; ?>></td>
	</tr>
	<tr>
		<th colspan="2">Messaje</th>
	</tr>
	<tr>
		<td>Adauga</td>
		<td><input type="text" name="add" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['message']['add'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Adauca un element') : smarty_modifier_default($_tmp, 'Adauca un element')); ?>
"></td>
	</tr>
	<tr>
		<td>Editeaza</td>
		<td><input type="text" name="edit" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['message']['edit'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Editeaza elementul') : smarty_modifier_default($_tmp, 'Editeaza elementul')); ?>
"></td>
	</tr>
	<tr>
		<td>Nu sunt imagini</td>
		<td><input type="text" name="no_images" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['message']['no_images'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Nu exista poze pentru acest element') : smarty_modifier_default($_tmp, 'Nu exista poze pentru acest element')); ?>
"></td>
	</tr>
	<tr>
		<td>Nu sunt fisiere</td>
		<td><input type="text" name="no_files" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['message']['no_files'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Nu exista fisiere pentru acest element') : smarty_modifier_default($_tmp, 'Nu exista fisiere pentru acest element')); ?>
"></td>
	</tr>
	<tr>
		<td>A fost adaugat</td>
		<td><input type="text" name="added" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['message']['added'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Elementul a fost adaugat cu succes') : smarty_modifier_default($_tmp, 'Elementul a fost adaugat cu succes')); ?>
"></td>
	</tr>
	<tr>
		<td>A fost sters</td>
		<td><input type="text" name="deleted" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['message']['deleted'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Elementul a fost sters cu succes') : smarty_modifier_default($_tmp, 'Elementul a fost sters cu succes')); ?>
"></td>
	</tr>
</table>
<h3 class="marg-top">Elemente</h3>
<table id="elements">
	<tr>
		<th>Nume friendly</th>
		<th>Nume baza de date</th>
		<th>Tip</th>
		<th>Obligatoriu</th>
		<th>Tip coloana</th>
		<th><img class="element_add" src="template/images/icons/add.png" alt="add"></th>
	</tr>
	<?php $_from = $this->_tpl_vars['elements']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['elements'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['elements']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['elKey'] => $this->_tpl_vars['el']):
        $this->_foreach['elements']['iteration']++;
?>
	<tr id="element_<?php echo ($this->_foreach['elements']['iteration']-1); ?>
">
		<td><input class="small" type="text" value="<?php echo $this->_tpl_vars['el']['friendlyName']; ?>
" name="elements[<?php echo ($this->_foreach['elements']['iteration']-1); ?>
][friendlyName]"></td>
		<td><input class="small" type="text" value="<?php echo $this->_tpl_vars['elKey']; ?>
" name="elements[<?php echo ($this->_foreach['elements']['iteration']-1); ?>
][databaseName]"></td>
		<td>
			<select name="elements[<?php echo ($this->_foreach['elements']['iteration']-1); ?>
][type]" class="small">
			<?php $_from = $this->_tpl_vars['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_type']):
?>
				<option<?php if ($this->_tpl_vars['el']['type'] == $this->_tpl_vars['_type']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['_type']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
		<td>
			<label>Nu <input type="radio" name="elements[<?php echo ($this->_foreach['elements']['iteration']-1); ?>
][required]" value="0"<?php if (! $this->_tpl_vars['el']['required']): ?> checked="checked"<?php endif; ?>></label>
			<label>Da <input type="radio" name="elements[<?php echo ($this->_foreach['elements']['iteration']-1); ?>
][required]" value="1"<?php if ($this->_tpl_vars['el']['required']): ?> checked="checked"<?php endif; ?>></label>
		</td>
		<td><input class="small" type="text" value="<?php echo $this->_tpl_vars['el']['colType']; ?>
" name="elements[<?php echo ($this->_foreach['elements']['iteration']-1); ?>
][colType]"></td>
		<td><img class="element_del" src="template/images/icons/remove.png" alt="del"></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	<tr>
		<td colspan="6">
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
">
			<input type="hidden" name="act" value="do_edit">
			<input type="submit" value="Submit">
		</td>
	</tr>
</table>
</form>
<div id="debug"></div>
<script>
<?php echo '
	
	$(document).ready(function() { // on load
		if ($(\'#elements tr\').size() > 3) {
			$(\'.element_del\').show();
		}
	});
	
	$(document).on(\'click\', \'.element_add\', function() { // add new element
		var tabel = $(\'#elements tr\');
		var size = parseInt(tabel.eq(-2).attr(\'id\').split(\'_\')[1]) + 1;
		var tr = \'<tr id="element_\' + size + \'">\' + tabel.eq(1).html() + \'</tr>\';
		
		tr = tr.replace(/value="?[^"\\s]+"?\\s+name="?elements\\[[0-9]+\\]\\[friendlyName\\]"?/gi, \'name="elements[\' + size + \'][friendlyName]"\')
			.replace(/value="?[^"\\s]+"?\\s+name="?elements\\[[0-9]+\\]\\[databaseName\\]"?/gi, \'name="elements[\' + size + \'][databaseName]"\')
			.replace(/\\[[0-9]+\\]\\[required\\]/gi, \'[\' + size + \'][required]\')
			.replace(/value="?[^"\\s]+"?\\s+name="?elements\\[[0-9]+\\]\\[colType\\]"?/gi, \'name="elements[\' + size + \'][colType]"\')
			.replace(/\\[[0-9]+\\]\\[type\\]/gi, \'[\' + size + \'][type]"\')
			.replace(/option\\s+selected(="?selected"?)?/gi, \'option\');
		$(\'#debug\').text(tr);
		$(tr).insertBefore(\'#elements tr:last\');
		
		if (tabel.size() > 2) {
			$(\'.element_del\').show();
		}
	});
	
	$(document).on(\'click\', \'.element_del\', function() { // delete a element
		var conf = confirm(\'Esti sugur ca vrei sa stergi?\');
		
		if (conf) {
			var _ = $(this);
			var id = _.parent(\'td\').parent(\'tr\').attr(\'id\').split(\'_\')[1];
			var size = $(\'#elements tr\').size();
			$(\'#element_\' + id).remove();
			
			console.log(size);
			if (size <= 4) {
				$(\'.element_del\').hide();
			}
		}
	});
	
	function htmlEntities(str) {
		return String(str).replace(/&/g, \'&amp;\').replace(/</g, \'&lt;\').replace(/>/g, \'&gt;\').replace(/"/g, \'&quot;\');
	}
'; ?>

</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "parts/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>