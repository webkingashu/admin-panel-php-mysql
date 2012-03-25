<?php

class Auth {
	
	protected static $_adminsTable     = 'sys_admins';
	protected static $_adminsLogTable  = 'sys_admins_log';
	
	public function __construct() {}
	
	public function login($params = array()) {
		if (
			empty($params['username']) ||
			empty($params['password'])
			) {
			return false;
		}
		
		$item = DB::select()
			->from(self::$_adminsTable)
			->where(
				'username = ? AND password = ?', 
				array($params['username'], md5($params['password']))
			)
			->exec();
		
		if (count($item) == 1) {
			/**
			 * Add to log
			 */
			$params = array(
				$item[0]['id'],
				$_SERVER['REMOTE_ADDR'],
				time()
			);
		
			$stmt = "INSERT INTO `" . self::$_adminsLogTable . "` 
					(`admin_id`, `ip`, `date`) 
					VALUES (?, ?, ?)";
			$sql = DB::getInstance()->prepare($stmt, $params);
			DB::query($sql);
			
			/**
			 * Delete from log if > 10
			 */
			$sql = "DELETE FROM `" . self::$_adminsLogTable . "` 
					WHERE id IN (
						SELECT * FROM (
							SELECT 0
							UNION
							(SELECT id FROM `" . self::$_adminsLogTable . "`
							ORDER BY `id` DESC
							LIMIT 10, 10)
						) AS tab
					)";
			DB::query($sql);
			
			$_SESSION['admin_details'] = $item[0];
			return true;
		}
		return false;
	}
	
	public function logout() {
		unset($_SESSION['admin_details']);
		return true;
	}
	
	public function getAdminDetails() {
		if (session('admin_details') == null) {
			return false;
		}
		return session('admin_details');
	}
	
	public function isLogged() {
		if (!self::getAdminDetails()) {
			return false;
		}
		return true;
	}
	
	public function checkPass($password) {
		$hash         = md5($password);
		$adminDetails = self::getAdminDetails();
		
		$result = DB::select('1')
			->from(self::$_adminsTable)
			->where('username=? AND password=?', array($adminDetails['username'], $hash))
			->exec(true);
		if (DB::rowCount($result) == 1) {
			return true;
		}
		return false;
	}
	
	public function setNewPassword($params) {
		if (
			$params['newpass'] != $params['renewpass'] ||
			strlen($params['newpass']) < 6
			) {
			return false;
		}
		$adminDetails = self::getAdminDetails();
		
		$stmt = "UPDATE `" . self::$_adminsTable . "` SET password=? WHERE id=?";
		$sql  = DB::getInstance()->prepare($stmt, array(md5($params['newpass']), $adminDetails['id']));
		DB::query($sql);
		return true;
	}
	
	public function getAdminsLogTable() {
		return self::$_adminsLogTable;
	}
	
	public function getAdminsTable() {
		return self::$_adminsTable;
	}
}