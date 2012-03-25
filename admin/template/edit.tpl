{include file="parts/header.tpl"}
{include file="parts/sidebar.tpl"}
{include file="parts/message.tpl"}

<form action="core/{$config.tableName}/" method="post" onsubmit="return checkRequired()" name="editForm">
<table>
	<tr>
		<th colspan="2">{$message.edit}</th>
	</tr>
	{foreach from=$fields item=field name=fields}
	<tr class="top">
		<td>
			{$field.friendlyName}
			{if $field.required}
			<span class="highlight">*</span>
			{/if}
		</td>
		<td>
			{if $field.type=='text'}
			<input type="text" name="{$field.databaseName}" value="{$field.value}">
			{elseif $field.type=='editor'}
			<textarea id="field_{$field.databaseName}" name="{$field.databaseName}" style="width:460px; height:100px;">{$field.value}</textarea>
			<script type="text/javascript"> addTinyMCEEl('field_{$field.databaseName}'); </script>
			{elseif $field.type=='textarea'}
			<textarea name="{$field.databaseName}" style="width:541px; height:100px;">{$field.value}</textarea>
			{/if}
		</td>
	</tr>
	{/foreach}
	{if $config.functionVisible}
	<tr>
		<td style="width:150px;">Visible</td>
		<td><input type="checkbox" name="visible"{if $item.visible || !$smarty.get.id} checked="checked"{/if}></td>
	</tr>
	{/if}
	<tr>
		<td colspan="2">
			<input type="hidden" name="id" value="{$smarty.get.id}">
			<input type="hidden" name="act" value="do_edit">
			<input type="submit" value="Submit">
		</td>
	</tr>
</table>
</form>

<script>
{literal}
	function checkRequired() {
{/literal}
		var error = '';
		var form  = document.forms.editForm;
		
{foreach from=$fields item=field}
{if $field.required}
	{if $field.type == 'editor'}
		if (tinyMCE.get('field_{$field.databaseName}').getContent() == '') 
	{else}
		if (form.{$field.databaseName}.value == '') 
	{/if}
			error += 'Campul `{$field.friendlyName}` este obligatoriu\n';
{/if}
{/foreach}
{literal}
		if (error) {
			alert(error.replace(/\n$/, ''));
			return false;
		}
		return true;
	}
{/literal}
</script>

{include file="parts/footer.tpl"}