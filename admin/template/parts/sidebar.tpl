	<div id="content">
		<div class="indent">
			<div class="col-1">
				<ul id="menu">
					<li>
						<b>Continut</b>
						{if $corePages}
						<ul>
						  {foreach from=$corePages item=_page}
							<li><a href="core/{$_page.table_name}/">{$_page.name}</a></li>
						  {/foreach}
						</ul>
						{/if}
					</li>
					<li>
						<b>Sistem</b>
						<ul>
							<li><a href="./">Log-uri</a></li>
							<li><a href="general-settings/">Setari generale</a></li>
							<li id="tables-settings"><a href="tables-settings/">Setari tabele</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="col-2">