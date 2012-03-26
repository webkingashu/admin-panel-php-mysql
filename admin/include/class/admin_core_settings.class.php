<?php

class Admin_Core_Settings {
	
	protected $_tpl;
	protected $_config;
	
	protected  static $_coreSetupTable = 'sys_core_setup';
	
	public function __construct(Config $config) {
		$this->_config = $config;
		$this->_tpl    = $config->get('tpl');
		$this->init();
	}
	
	/* Action functions */
	public function index() {
		
		$items = DB::select('`id`, `name`, `order`, `visible`')
			->from(self::$_coreSetupTable)
			->exec();
		$this->_tpl->items = $items;
		
		$this->_tpl->display('coreSettingsList.tpl');
	}
	
	public function edit() {
		
		if (get('id') != null) {
			$item = DB::select()
				->from(self::$_coreSetupTable)
				->where('id=?', get('id'))
				->exec();
			$settings = unserialize($item[0]['settings']);
			
			$this->_tpl->config   = $settings['config'];
			$this->_tpl->message  = $settings['message'];
			$this->_tpl->elements = $settings['elements'];
			$this->_tpl->filter   = implode(', ', $settings['filter']);
		} else {
			$this->_tpl->elements = array(
				'nume' => array(
					'friendlyName' => 'Nume',
					'type'         => 'text',
					'required'     => 1,
					'colType'      => 'varchar|100',
				)
			);
		}
		
		/* Elements possible types */
		$this->_tpl->types = array('text', 'textarea', 'editor');
	
		$this->_tpl->display('coreSettingsEdit.tpl');
	}
	
	public function do_edit() {
		$settings = array(
			'config' => array(
				'tableName'             => post('tableName'),
				'pageName'              => post('pageName'),
				'displaiedName'         => post('displaiedName'),
				'displaiedFriendlyName' => post('displaiedFriendlyName'),
				'limitPerPage'          => post('limitPerPage'),
				
				'functionAdd'           => post('functionAdd') == 'on' ? 1 : 0,
				'functionEdit'          => post('functionEdit') == 'on' ? 1 : 0,
				'functionDelete'        => post('functionDelete') == 'on' ? 1 : 0,
				'functionSetOrder'      => post('functionSetOrder') == 'on' ? 1 : 0,
				'functionVisible'       => post('functionVisible') == 'on' ? 1 : 0,
				'functionCreateTable'   => post('functionCreateTable') == 'on' ? 1 : 0,
			),
			'message' => array(
				'add'       => post('add'),
				'edit'      => post('edit'),
				'no_images' => post('no_images'),
				'no_files'  => post('no_files'),
				'added'     => post('added'),
				'deleted'   => post('deleted'),
			),
			'filter' => array_map('trim', explode(',', post('filter'))),
		);
		$settings['elements'] = array();
		foreach (post('elements') as $element) {
			if (
				trim($element['databaseName']) != '' ||
				trim($element['friendlyName']) != '' ||
				trim($element['type']) != '' ||
				trim($element['required']) != '' ||
				trim($element['colType']) != ''
				) {
				$settings['elements'][trim($element['databaseName'])] = array(
					'friendlyName' => trim($element['friendlyName']),
					'type'         => $element['type'],
					'required'     => $element['required'],
					'colType'      => trim($element['colType']),
				);
			}
		}
		
		if ($id = (int) request('id')) {
			$stmt = "UPDATE `" . self::$_coreSetupTable . "` SET `name`=?, `table_name`=?, `settings`=?
					WHERE id=?";
			$params = array(post('pageName'), post('tableName'), serialize($settings), $id);
			
			$message = 'Tebela a fost modificata';
		} else {
			$count = DB::count(self::$_coreSetupTable);
			$stmt = "INSERT INTO `" . self::$_coreSetupTable . "` (`name`, `table_name`, `settings`, `order`, `visible`)
					VALUES(?, ?, ?, ?, ?)";
			$params = array(post('pageName'), post('tableName'), serialize($settings), ++$count, 1);
			
			$message = 'Tebela a fost adaugata';
		}
		$sql = DB::prepare($stmt, $params);
		DB::query($sql);
		
		message($message, 'succes');
		location(ADMIN_URL . 'tables-settings/');
	}
	
	public function delete() {
		if ($id = (int) get('id')) {
			$sql = "SELECT `table_name` 
					FROM `" . self::$_coreSetupTable . "`
					WHERE id='$id'";
			$result = DB::query($sql);
			$tableName = mysql_result($result, 0);
			
			/* Delete table reference */
			$sql = "DROP TABLE `$tableName`";
			DB::query($sql);
			
			/* Delete from system table */
			$sql = "DELETE FROM `" . self::$_coreSetupTable . "` 
					WHERE id='$id'";
			DB::query($sql);
		}
		
		message('Tabelul a fost sters cu succes', 'succes');
		location(ADMIN_URL . 'tables-settings/');
	}
	
	/* General functions */
	public function getVisibleTable() {
		$sql = "SELECT name, table_name 
				FROM `" . self::$_coreSetupTable . "` 
				WHERE visible=1";
		return DB::fetchAll($sql);
	}
	
	public function getPageSettings($tableName) {
		$stmt = "SELECT `settings` 
				FROM `" . self::$_coreSetupTable . "`
				WHERE `table_name`=?";
		$sql = DB::prepare($stmt, $tableName);
		$result = DB::query($sql);
		return unserialize(mysql_result($result, 0));
	}
	
	/* System functions */
	public function init() {
		/* Posible actions */
		$actions = array(
			'index', 'edit', 'do_edit', 'delete', 'modify'
		);
	
		if (in_array(request('act'), $actions)) {
			$action = request('act');
		} else {
			$action = 'index';
		}
		
		$this->{$action}();
	}
}