<?php /* Smarty version 2.6.26, created on 2012-03-23 11:05:02
         compiled from parts/sidebar.tpl */ ?>
	<div id="content">
		<div class="indent">
			<div class="col-1">
				<ul id="menu">
					<li>
						<b>Continut</b>
						<?php if ($this->_tpl_vars['corePages']): ?>
						<ul>
						  <?php $_from = $this->_tpl_vars['corePages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_page']):
?>
							<li><a href="core/<?php echo $this->_tpl_vars['_page']['table_name']; ?>
/"><?php echo $this->_tpl_vars['_page']['name']; ?>
</a></li>
						  <?php endforeach; endif; unset($_from); ?>
						</ul>
						<?php endif; ?>
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