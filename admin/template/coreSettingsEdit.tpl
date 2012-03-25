{include file="parts/header.tpl"}
{include file="parts/sidebar.tpl"}
{include file="parts/message.tpl"}

<form action="tables-settings/" method="post" name="editForm">
<h3>Setari generale</h3>
<table>
	<tr>
		<th colspan="2">Setari afisare</th>
	</tr>
	<tr>
		<td>Nume tabel</td>
		<td><input type="text" name="tableName" value="{$config.tableName}"></td>
	</tr>
	<tr>
		<td>Nume pagina</td>
		<td><input type="text" name="pageName" value="{$config.pageName}"></td>
	</tr>
	<tr>
		<td>Nume afisat</td>
		<td><input type="text" name="displaiedName" value="{$config.displaiedName|default:'nume'}"></td>
	</tr>
	<tr>
		<td>Nume friendly afisat</td>
		<td><input type="text" name="displaiedFriendlyName" value="{$config.displaiedFriendlyName|default:'Nume'}"></td>
	</tr>
	<tr>
		<td>Limita pe pagina</td>
		<td><input type="text" name="limitPerPage" value="{$config.limitPerPage|default:20}"></td>
	</tr>
	<tr>
		<th colspan="2">Functii</th>
	</tr>
	<tr>
		<td>Adaugare</td>
		<td><input type="checkbox" name="functionAdd"{if $config.functionAdd || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	<tr>
		<td>Editare</td>
		<td><input type="checkbox" name="functionEdit"{if $config.functionEdit || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	<tr>
		<td>Stergere</td>
		<td><input type="checkbox" name="functionDelete"{if $config.functionDelete || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	<tr>
		<td>Seteaza orfinea</td>
		<td><input type="checkbox" name="functionSetOrder"{if $config.functionSetOrder || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	<tr>
		<td>Vizibil pe site</td>
		<td><input type="checkbox" name="functionVisible"{if $config.functionVisible || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	<tr>
		<td>Creaza tabel</td>
		<td><input type="checkbox" name="functionCreateTable"{if $config.functionCreateTable || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	<tr>
		<th colspan="2">Messaje</th>
	</tr>
	<tr>
		<td>Adauga</td>
		<td><input type="text" name="add" value="{$message.add|default:'Adauca un element'}"></td>
	</tr>
	<tr>
		<td>Editeaza</td>
		<td><input type="text" name="edit" value="{$message.edit|default:'Editeaza elementul'}"></td>
	</tr>
	<tr>
		<td>Nu sunt imagini</td>
		<td><input type="text" name="no_images" value="{$message.no_images|default:'Nu exista poze pentru acest element'}"></td>
	</tr>
	<tr>
		<td>Nu sunt fisiere</td>
		<td><input type="text" name="no_files" value="{$message.no_files|default:'Nu exista fisiere pentru acest element'}"></td>
	</tr>
	<tr>
		<td>A fost adaugat</td>
		<td><input type="text" name="added" value="{$message.added|default:'Elementul a fost adaugat cu succes'}"></td>
	</tr>
	<tr>
		<td>A fost sters</td>
		<td><input type="text" name="deleted" value="{$message.deleted|default:'Elementul a fost sters cu succes'}"></td>
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
	{foreach from=$elements item=el key=elKey name=elements}
	<tr id="element_{$smarty.foreach.elements.index}">
		<td><input class="small" type="text" value="{$el.friendlyName}" name="elements[{$smarty.foreach.elements.index}][friendlyName]"></td>
		<td><input class="small" type="text" value="{$elKey}" name="elements[{$smarty.foreach.elements.index}][databaseName]"></td>
		<td>
			<select name="elements[{$smarty.foreach.elements.index}][type]" class="small">
			{foreach from=$types item=_type}
				<option{if $el.type==$_type} selected{/if}>{$_type}</option>
			{/foreach}
			</select>
		</td>
		<td>
			<label>Nu <input type="radio" name="elements[{$smarty.foreach.elements.index}][required]" value="0"{if !$el.required} checked="checked"{/if}></label>
			<label>Da <input type="radio" name="elements[{$smarty.foreach.elements.index}][required]" value="1"{if $el.required} checked="checked"{/if}></label>
		</td>
		<td><input class="small" type="text" value="{$el.colType}" name="elements[{$smarty.foreach.elements.index}][colType]"></td>
		<td><img class="element_del" src="template/images/icons/remove.png" alt="del"></td>
	</tr>
	{/foreach}
	<tr>
		<td colspan="6">
			<input type="hidden" name="id" value="{$smarty.get.id}">
			<input type="hidden" name="act" value="do_edit">
			<input type="submit" value="Submit">
		</td>
	</tr>
</table>
</form>
<div id="debug"></div>
<script>
{literal}
	
	$(document).ready(function() { // on load
		if ($('#elements tr').size() > 3) {
			$('.element_del').show();
		}
	});
	
	$(document).on('click', '.element_add', function() { // add new element
		var tabel = $('#elements tr');
		var size = parseInt(tabel.eq(-2).attr('id').split('_')[1]) + 1;
		var tr = '<tr id="element_' + size + '">' + tabel.eq(1).html() + '</tr>';
		
		tr = tr.replace(/value="?[^"\s]+"?\s+name="?elements\[[0-9]+\]\[friendlyName\]"?/gi, 'name="elements[' + size + '][friendlyName]"')
			.replace(/value="?[^"\s]+"?\s+name="?elements\[[0-9]+\]\[databaseName\]"?/gi, 'name="elements[' + size + '][databaseName]"')
			.replace(/\[[0-9]+\]\[required\]/gi, '[' + size + '][required]')
			.replace(/value="?[^"\s]+"?\s+name="?elements\[[0-9]+\]\[colType\]"?/gi, 'name="elements[' + size + '][colType]"')
			.replace(/\[[0-9]+\]\[type\]/gi, '[' + size + '][type]"')
			.replace(/option\s+selected(="?selected"?)?/gi, 'option');
		// $('#debug').text(tr);
		$(tr).insertBefore('#elements tr:last');
		
		if (tabel.size() > 2) {
			$('.element_del').show();
		}
	});
	
	$(document).on('click', '.element_del', function() { // delete a element
		var conf = confirm('Esti sugur ca vrei sa stergi?');
		
		if (conf) {
			var _ = $(this);
			var id = _.parent('td').parent('tr').attr('id').split('_')[1];
			var size = $('#elements tr').size();
			$('#element_' + id).remove();
			
			console.log(size);
			if (size <= 4) {
				$('.element_del').hide();
			}
		}
	});
	
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
{/literal}
</script>

{include file="parts/footer.tpl"}