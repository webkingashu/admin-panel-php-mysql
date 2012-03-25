<?php

class Admin_Core {
	
	protected $_config;
	protected $_settings;
	protected $_tpl;
	protected $_fields    = array();
	
	public function __construct(Config $config, $settings = array()) {
		$this->_config   = $config;
		$this->_settings = $settings;
		
		/* Template vars */
		$this->_tpl      = $config->get('tpl');
		$this->_tpl->config  = $settings['config'];
		$this->_tpl->message = $settings['message'];
		
		$this->init();
	}
	
	/**
	 *	Action methods
	 */
	public function index() {
		$cond = '1';
		$params = array();
		
		/* Filter */
		if (
			!empty($this->_settings['filter']) &&
			is_array($this->_settings['filter'])
			) {
			$filters = array();
			$i = 0;
			
			if (in_array('id', $this->_settings['filter'])) {
				$filters[$i]['type'] = 'text';
				$filters[$i]['friendlyName'] = 'ID';
				$filters[$i]['databaseName'] = 'id';
				$filters[$i]['value'] = filter($this->_settings['config']['tableName'], 'id');
				$i++;
			}
			
			foreach ($this->_fields as $field) {
				if (in_array($field['databaseName'], $this->_settings['filter'])) {
					if (
						$field['type'] == 'text' ||
						$field['type'] == 'textarea' ||
						$field['type'] == 'editor' 
						) {
						$filters[$i]['type'] = 'text';
						$filters[$i]['friendlyName'] = $field['friendlyName'];
						$filters[$i]['databaseName'] = $field['databaseName'];
						$filters[$i]['value'] = filter($this->_settings['config']['tableName'], $field['databaseName']);
						
						$cond .= " AND `{$filters[$i]['databaseName']}` LIKE ?"; // sql cond
						$params[] = "%{$filters[$i]['value']}%";
					}
					$i++;
				}
			}
			
			$this->_tpl->filters = $filters;
		}
		
		/* SET total, limit, offset and page for PAGER */
		$stmt = "SELECT COUNT(*) FROM `{$this->_settings['config']['tableName']}` WHERE $cond";
		$sql  = DB::prepare($stmt, $params);
		$result = DB::query($sql);
		
		$total = mysql_result($result, 0);
		$limit = $this->_settings['config']['limitPerPage'];
		$page  = get('page');
		if ($page < 1 || $page > ceil($total / $limit)) { $page = 1; }
		$offset = ($page * $limit) - $limit;
		
		/* Order */
		$displaiedName = $this->_settings['config']['displaiedName'];
		
		$orderCols = array(
			$this->_settings['config']['displaiedName'], 
			'order', 
			'visible'
		);
		
		$order = in_array(get('order'), $orderCols) ? get('order') : 'order';
		$dir   = preg_match('/DESC/i', get('dir')) ? 'desc' : 'asc';
		
		$linkPattern  = 'core/' . $this->_settings['config']['tableName'] . '/?page=' . $page;
		$linkPattern .= '&amp;order={ORDER}&amp;dir={DIR}';
		
		$orderLinks = array();
		$orderImage = array();
		for ($i = 0;$i < 3;$i++) {
			switch ($i) {
				case'0': $key = $displaiedName; break;
				case'1': $key = 'order'; break;
				case'2': $key = 'visible'; break;
			}
			$search = array(
				'{ORDER}' => $key,
				'{DIR}'   => ($dir == 'asc' && $order == $key ? 'desc' : 'asc') 
			);
			$orderLinks[$key] = str_replace(array_keys($search), array_values($search), $linkPattern);
			$orderImage[$key] = $order == $key ? '<img src="template/images/icons/arrow_' . strtolower($dir) . '.png" alt="">' : '';
		}
		$this->_tpl->order    = $orderLinks;
		$this->_tpl->dirOrder = $orderImage;
		
		/* Display items */
		$items = DB::select()
			->from($this->_settings['config']['tableName'])
			->where($cond, $params)
			->order("`$order` $dir")
			->limit($offset, $limit)
			->exec();
		$this->_tpl->items = $items;
		
		$pager = array(
			'page'    => $page,
			'limit'   => $limit,
			'total'   => $total,
			'pattern' => 'core/' . $this->_settings['config']['tableName'] . '/?page={PAGE}&amp;order=' . $order . '&amp;dir=' . $dir,
		);
		
		$this->_tpl->pager = new Pager($pager);
		
		/* Colspan */
		$colspan = 5;
		if (empty($this->_settings['config']['functionSetOrder'])) {
			$colspan--;
		}
		if (empty($this->_settings['config']['functionVisible'])) {
			$colspan--;
		}
		$this->_tpl->colspan = $colspan;
		
		$this->_tpl->display('list.tpl');
	}
	
	public function edit() {
		if (
			$this->_settings['config']['functionEdit'] &&
			(int) get('id') != 0
			) {
			$result = DB::select()
				->from($this->_settings['config']['tableName'])
				->where('id=?', get('id'))
				->exec(true);
			if (DB::rowCount($result) != 1) {
				message('Nu exista nici o intrare cu acel id', 'error');
				location(ADMIN_URL . 'core/' . $this->_settings['config']['tableName'] . '/');
			}
			$item = DB::fetch($result);
			$this->_tpl->item = $item;
		} else if (!$this->_settings['config']['functionAdd']) {
			message('Functiile Add/Edit sunt oprite', 'error');
			location(ADMIN_URL . 'core/' . $this->_settings['config']['tableName'] . '/');
		}
		
		foreach ($this->_fields as &$field) {
			$field['value'] = isset($item[$field['databaseName']]) ? $item[$field['databaseName']] : '';
			if ($field['type'] == 'editor') {
				$field['value'] = htmlspecialchars($field['value'], ENT_COMPAT, 'UTF-8');
			}
		}
		
		$this->_tpl->fields = $this->_fields;
		
		$this->_tpl->display('edit.tpl');
	}
	
	public function do_edit() {
		if (post('id') != 0) {
			$stmt = "UPDATE `{$this->_settings['config']['tableName']}` SET ";
			$action = 'edit';
		} else {
			$stmt = "INSERT INTO `{$this->_settings['config']['tableName']}` SET ";
			$action = 'add';
		}
		
		$params = array();
		foreach ($this->_fields as $field) {
			if ($field['type'] == 'editor') {
				$stmt .= "`{$field['databaseName']}`=?, ";
				$params[] = post($field['databaseName']);
			} else {
				$stmt .= "`{$field['databaseName']}`=?, ";
				$params[] = strip_tags(post($field['databaseName']));
			}
		}
		
		if ($this->_settings['config']['functionVisible']) {
			$stmt .= "`visible`=?, ";
			$params[] = post('visible') == 'on' ? 1 : 0;
		}
		if (
			$this->_settings['config']['functionSetOrder'] && 
			$action == 'add'
			) {
			$count = DB::count($this->_settings['config']['tableName']);
			$stmt .= "`order`=?, ";
			$params[] = ++$count;
		}
		$stmt = rtrim($stmt, ', ');
		if ($action == 'edit') {
			$stmt .= " WHERE `id`=?";
			$params[] = post('id');
		}
		$sql = DB::prepare($stmt, $params);
		DB::query($sql);
		
		if ($action == 'add') {
			message($this->_settings['message']['added'], 'succes');
		} else {
			message('Schimbare facuta cu succes', 'succes');
		}
		location(ADMIN_URL . 'core/' . $this->_settings['config']['tableName'] . '/');
	}
	
	public function delete() {
		if ($this->_settings['config']['functionDelete']) {
			$sql = "DELETE FROM `{$this->_settings['config']['tableName']}` 
					WHERE id='" . (int) get('id') . "'";
			DB::query($sql);
			message($this->_settings['message']['deleted'], 'succes');
		}
		location($_SERVER['HTTP_REFERER']);
	}
	
	public function modify() {
		if (post('submit') == 'Schimba ordinea') {
			foreach ($_POST as $key=>$value) {
				if (preg_match('/order\_([0-9]+)/i', $key, $match)) {
					$id = $match[1];
					$stmt = "UPDATE `{$this->_settings['config']['tableName']}` SET
							`order`=? WHERE `id`=?";
					$sql  = DB::prepare($stmt, array($value, $id));
					DB::query($sql);
				}
			}
			message('Ordinea a fost schimbata', 'succes');
		} else if (post('submit') == 'Sterge') {
			$items   = array_keys(post('items'));
			$items[] = 0;
			$sql = "DELETE FROM `{$this->_settings['config']['tableName']}`
					WHERE `id` IN (" . implode(', ', $items) . ")";
			DB::query($sql);
			message('Elementele au fost sterse', 'succes');
		}
		location($_SERVER['HTTP_REFERER']);
	}
	
	public function modify_filters() {
		if (post('submit') == 'Filtreaza') {
			foreach ($_POST as $key=>$value) {
				if ($key != 'act') {
					$_SESSION['filter'][$this->_settings['config']['tableName']][$key] = $value;
				}
			}
			$message = 'Filtrele au fost aplicate cu succes!';
		} else {
			$_SESSION['filter'][$this->_settings['config']['tableName']] = array();
			$message = 'Filtrele au fost sterse cu succes!';
		}
		message($message, 'succes');
		location($_SERVER['HTTP_REFERER']);
	}
	
	/**
	 *	Sistem methods
	 */
	public function init() {
		foreach ($this->_settings['elements'] as $key=>$el) {
			$this->_fields[] = array(
				'databaseName'  => $key,
				'friendlyName'  => $el['friendlyName'],
				'type'          => $el['type'],
				'required'      => $el['required'],
				'colType'       => $el['colType'],
			);
		}
		
		$this->verifyTable(); /* create table, add fields, delete fields */
		
		/* Posible actions */
		$actions = array(
			'index', 'edit', 'do_edit', 'delete', 
			'modify', 'modify_filters'
		);
		
		if (in_array(request('act'), $actions)) {
			$action = request('act');
		} else {
			$action = 'index';
		}
		
		$this->{$action}();
	}
	
	public function verifyTable() {
		
		$message = '';
		
		if ($this->_settings['config']['functionCreateTable'] == true && empty($_POST)) {
			$sql = "SHOW TABLES LIKE '{$this->_settings['config']['tableName']}'";
			$result = DB::query($sql);
			if (DB::rowCount($result) == 0) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->_settings['config']['tableName']}` (
						 `id` int(11) NOT NULL AUTO_INCREMENT,";
				
				foreach ($this->_fields as $field) {
					$colType = explode('|', $field['colType']);
					$sql .= "`{$field['databaseName']}` {$colType[0]}";
					if (isset($colType[1])) { $sql .= "({$colType[1]})"; }
					$sql .= " NOT NULL";
					if (isset($colType[2])) { $sql .= " DEFAULT '{$colType[2]}"; }
					$sql .= ",";
				}
				
				$sql .= "`visible` tinyint(1) NOT NULL DEFAULT '1',
						 `order` int(11) NOT NULL,
						 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				
				DB::query($sql);
				
				$message .= 'Am adaugat tabela ' . $this->_settings['config']['tableName'] . '!<br />';
			}
		}
		
		// Remove cols
		$sql = "DESCRIBE `{$this->_settings['config']['tableName']}`";
		$result = DB::query($sql);
		
		$fields = array();
		foreach ($this->_fields as $field) {
			$fields[] = $field['databaseName'];
		}
		
		$ignore = array('id', 'order', 'visible', 'updated_at');
		$count  = array();
		while ($row = DB::fetch($result)) {
			if (!in_array($row['Field'], $ignore)) {
				if (!in_array($row['Field'], $fields)) {
					$sql  = "ALTER TABLE `{$this->_settings['config']['tableName']}` DROP `{$row['Field']}`";
					DB::query($sql);
					
					$message .= 'Am sters coloana ' . $row['Field'] . '!<br />';
				} else {
					$count[] = $row['Field']; // make an array to compare
				}
			}
		}
		
		// Add cols
		foreach ($this->_settings['elements'] as $dbColName=>$field) {
			if (!in_array($dbColName, $count)) {
				$colType = explode('|', $field['colType']);
				$sql  = "ALTER TABLE `{$this->_settings['config']['tableName']}` ADD `{$dbColName}` {$colType[0]}";
				if (count($colType) > 1) { $sql .= "({$colType[1]})"; }
				DB::query($sql);
				
				$message .= 'Am adaugat coloana ' . $dbColName . '!<br />';
			}
		}
		
		if ($message) {
			message($message, 'succes');
			location(currentUrl());
		}
	}
}