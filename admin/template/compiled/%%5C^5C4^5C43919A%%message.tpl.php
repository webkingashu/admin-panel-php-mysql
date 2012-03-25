<?php /* Smarty version 2.6.26, created on 2012-03-24 19:10:07
         compiled from parts/message.tpl */ ?>
<?php if ($this->_tpl_vars['message_text']): ?>
	<div class="<?php echo $this->_tpl_vars['message_type']; ?>
"<?php if ($this->_tpl_vars['message_width']): ?> style="width:<?php echo $this->_tpl_vars['message_width']; ?>
px;"<?php endif; ?>>
		<?php echo $this->_tpl_vars['message_text']; ?>

	</div>
<?php endif; ?>