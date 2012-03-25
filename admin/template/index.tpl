{include file="parts/header.tpl"}
{include file="parts/sidebar.tpl"}
{include file="parts/message.tpl"}

<h2>Ultimele logari</h2>
<table>
	<tr>
		<th>Username</th>
		<th style="width:200px;">IP</th>
		<th style="width:200px;">Data</th>
	</tr>
	{foreach from=$userLog item=item name=userLog}
	<tr>
		<td>{$item.username}</td>
		<td>{$item.ip}</td>
		<td>{$item.date|date_format:"%d %b %Y, %H:%M"}</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="3">Nu exista nici o intrare</td>
	</tr>
	{/foreach}
</table>
<br />
<div class="note">Apasati tasta "F8" pentru setarea tabelurilor</div>

{include file="parts/footer.tpl"}