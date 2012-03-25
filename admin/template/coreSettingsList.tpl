{include file="parts/header.tpl"}
{include file="parts/sidebar.tpl"}
{include file="parts/message.tpl"}

<form action="tables-settings/" method="post">
<table>
	<tr>
		<th class="center" style="width:20px;"><input type="checkbox" class="sel_all"></th>
		<th><a href="{$order.name}">Name {$dirOrder.name}</a></th>
		<th class="visible center"><a href="{$order.order}">Order {$dirOrder.order}</a></th>
		<th class="visible center"><a href="{$order.visible}">Visible {$dirOrder.visible}</a></th>
		<th class="actions center">Actions</th>
	</tr>
	{foreach from=$items item=item name=items}
	<tr>
		<td class="center"><input type="checkbox" class="cb" name="item[{$item.id}]"></td>
		<td>{$item.name}</td>
		<td class="center"><input class="order" value="{$item.order}" type="text" name="order_{$item.id}"></td>
		<td class="center">
		  {if $item.visible}
			<img src="template/images/icons/checkmark.png" alt="">
		  {else}
			<img src="template/images/icons/delete.png" alt="">
		  {/if}
		</td>
		<td class="center">
			<a href="tables-settings/?act=edit&amp;id={$item.id}" title="Editeaza"><img src="template/images/icons/edit.png" alt=""></a>
			<a href="tables-settings/?act=delete&amp;id={$item.id}" onclick="return confirm('Esti sigur ?')" title="Sterge"><img src="template/images/icons/remove.png" alt=""></a>
		</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="5">Nu exista nici o intrare</td>
	</tr>
	{/foreach}
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
{$pager}

{include file="parts/footer.tpl"}