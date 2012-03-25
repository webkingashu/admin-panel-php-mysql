{include file="parts/header.tpl"}
{include file="parts/sidebar.tpl"}
{include file="parts/message.tpl"}

<form action="account/do_profile/" method="post">
<table>
	<tr>
		<th>Profil</th>
		<th></th>
	</tr>
	<tr>
		<td>Parola veche</td>
		<td><input type="password" name="oldpass"></td>
	</tr>
	<tr>
		<td>Parola noua</td>
		<td><input type="password" name="newpass"></td>
	</tr>
	<tr>
		<td>Retasteaza parola noua</td>
		<td><input type="password" name="renewpass"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit"></td>
	</tr>
</table>
</form>

{include file="parts/footer.tpl"}