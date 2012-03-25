{include file="parts/header.tpl"}
{include file="parts/sidebar.tpl"}
{include file="parts/message.tpl"}

{if $filters}
<form action="core/{$config.tableName}/" method="post">
<table>
	<tr>
		<th colspan="2">Filtrare</th>
	</tr>
	{foreach from=$filters item=filter name=filters}
	<tr>
		<td>{$filter.friendlyName}</td>
		<td>
			{if $filter.type == 'text'}
			<input type="text" name="{$filter.databaseName}" value="{$filter.value}">
			{/if}
		</td>
	</tr>
	{/foreach}
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
{/if}

<form action="core/{$config.tableName}/" method="post">
<table>
	<tr>
		<th class="center" style="width:20px;"><input type="checkbox" class="sel_all"></th>
		<th><a href="{$order[$config.displaiedName]}">{$config.displaiedFriendlyName} {$dirOrder[$config.displaiedName]}</a></th>
		{if $config.functionSetOrder}<th class="visible center"><a href="{$order.order}">Order {$dirOrder.order}</a></th>{/if}
		{if $config.functionVisible}<th class="visible center"><a href="{$order.visible}">Visible {$dirOrder.visible}</a></th>{/if}
		<th class="actions center">Actions</th>
	</tr>
	{foreach from=$items item=item name=items}
	<tr>
		<td class="center"><input type="checkbox" class="cb" name="item[{$item.id}]"></td>
		<td>{$item[$config.displaiedName]}</td>
		{if $config.functionSetOrder}<td class="center"><input class="order" value="{$item.order}" type="text" name="order_{$item.id}"></td>{/if}
		{if $config.functionVisible}
		<td class="center">
		  {if $item.visible}
			<img src="template/images/icons/checkmark.png" alt="">
		  {else}
			<img src="template/images/icons/delete.png" alt="">
		  {/if}
		</td>
		{/if}
		<td class="center">
			{if $config.functionEdit}<a href="core/{$config.tableName}/?act=edit&amp;id={$item.id}" title="Editeaza"><img src="template/images/icons/edit.png" alt=""></a>{/if}
			{if $config.functionDelete}<a href="core/{$config.tableName}/?act=delete&amp;id={$item.id}" onclick="return confirm('Esti sigur ?')" title="Sterge"><img src="template/images/icons/remove.png" alt=""></a>{/if}
			{if $config.functionImages}<a href="#" title="Imagini"><img src="template/images/icons/image.png" alt=""></a>{/if}
		</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="{$colspan}">Nu exista nici o intrare</td>
	</tr>
	{/foreach}
	<tr>
		<td colspan="{$colspan}">
			{if $config.functionSetOrder}<input type="submit" name="submit" value="Schimba ordinea">{/if}
			{if $config.functionDelete}<input type="submit" name="submit" value="Sterge">{/if}
			<input type="hidden" name="act" value="modify">
		</td>
	</tr>
</table>
</form>
{if $config.functionAdd}<a href="core/{$config.tableName}/?act=edit" class="add">{$message.add}</a>{/if}
<div class="clear"></div>
{$pager}

{include file="parts/footer.tpl"}