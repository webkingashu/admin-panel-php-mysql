{if $message_text}
	<div class="{$message_type}"{if $message_width} style="width:{$message_width}px;"{/if}>
		{$message_text}
	</div>
{/if}