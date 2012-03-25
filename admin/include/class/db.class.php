<?php

class DB {
	
	const FETCH_ASSOC = 0;
	const FETCH_OBJ   = 1;
	const FETCH_NUM   = 2;
	
	protected static $_instance  = null;
	protected static $_conn      = null;
	protected static $_query     = null;
	protected static $_showError = null;
	protected static $_error     = null;
	protected static $_sql       = null;
	protected static $_load      = 0;
	protected static $_cache     = null;
	protected static $_fetchMode = self::FETCH_ASSOC;
	protected static $_cacheDir  = 'userfiles/db_cache/';
	
	protected function __construct() {
		self::$_conn = @mysql_connect(DB_HOST . ':' . DB_PORT, DB_USER, DB_PASSWORD);
		if (!self::$_conn) {
			if (self::$_showError) {
				msg::printError(mysql_error());
			}
			die;
		}
		if (!@mysql_select_db(DB_NAME, self::$_conn)) {
			if (self::$_showError) {
				msg::printError(mysql_error());
			}
			die;
		}
		if (defined('DB_CHARSET') && !@mysql_set_charset(DB_CHARSET)) {
			if (self::$_showError) {
				msg::printError(mysql_error());
			}
		}
		if (defined('DB_CACHE')) {
			self::setCache(DB_CACHE);
		}
		if (get_magic_quotes_gpc() == 1) {
			$_GET    = array_map('self::_stripslashesDeep', $_GET);
			$_POST   = array_map('self::_stripslashesDeep', $_POST);
			$_COOKIE = array_map('self::_stripslashesDeep', $_COOKIE);
		}
	}
	
	public function showError($show = true) {
		self::$_showError = $show;
	}
	
	protected function __clone() { }
	
	public function __destruct() { 
		if (self::$_conn) {
			mysql_close(self::$_conn);
		}
	}
	
	public function getInstance() {
		if (!self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	public function setCache($cache = true, $cacheDir = false) {
		if ($cache) {
			self::$_cache = 1;
			if (is_dir($cacheDir)) {
				self::$_cacheDir = $cacheDir;
			}
		} else {
			self::$_cache = 0;
		}
	}
	
	protected function _searchCache($sql) {
		if (self::$_cache && preg_match('/^SELECT\s+.*?\s+FROM\s+`?([a-z]+)`?/i', trim($sql), $match)) {
			$cacheDir = BASE_DIR . self::$_cacheDir . $match[1] . '/';
			$cacheFile = $cacheDir . md5($sql) . '.php';
			if (file_exists($cacheFile)) {
				include $cacheFile;
				$data = unserialize($data);
				if (!$data) {
					$data = true;
				}
				return $data;
			}
		}
		return false;
	}
	
	protected function _doCache($sql, $data) {
		if (self::$_cache && preg_match('/^SELECT\s+.*\s+FROM\s+`?([a-z]+)`?/i', trim($sql), $match)) {
			$cacheDir = BASE_DIR . self::$_cacheDir . $match[1] . '/';
			if (!is_dir($cacheDir)) {
				if (!is_dir(BASE_DIR . self::$_cacheDir)) {
					mkdir(BASE_DIR . self::$_cacheDir);
				}
				mkdir($cacheDir);
			}
			$cacheFile = $cacheDir . md5($sql) . '.php';
			if ($fp = @fopen($cacheFile, 'a')) {
				fwrite($fp,'<?php $data="' . mysql_real_escape_string(stripslashes(serialize($data))) . '";');
				fclose($fp);
				return true;
			}
		}
		return false;
	}
	
	protected function _clearCache($sql) {
		if (preg_match('/^(INSERT\s+INTO\s+`?([a-z]+)`?|UPDATE\s`?([a-z]+)`?|DELETE\s+FROM\s+`?([a-z]+)`?)/i', trim($sql), $match)) {
			$cacheDir = BASE_DIR . self::$_cacheDir . $match[2] . '/';
			if ($hd = @opendir($cacheDir)) {
				while (($file = readdir($hd)) !== false) {
					if (is_file($cacheDir . $file)) {
						unlink($cacheDir . $file);
					}
				}
				closedir($hd);
			}
		}
	}
	
	public function loadTime() {
		return self::$_load;
	}
	
	public function query($sql) {
		$start = microtime(true);
		if (!self::$_query = @mysql_query($sql)) {
			if (self::$_showError) {
				msg::printError(mysql_error());
				msg::printMsg($sql, 'SQL');
			}
			exit;
		}
		self::$_load += (microtime(true) - $start);
		self::_clearCache($sql);
		return self::$_query;
	}
	
	public function select($fields = '*') {
		self::$_sql = "SELECT $fields ";
		return self::getInstance();
	}
	
	public function from($table) {
		self::$_sql .= "FROM $table ";
		return self::getInstance();
	}
	
	public function where($condition, $replace = null) {
		$condition = self::prepare($condition, $replace);
		self::$_sql .= "WHERE $condition ";
		return self::getInstance();
	}
	
	public function order($sort = '`order`') {
		self::$_sql .= "ORDER BY $sort ";
		return self::getInstance();
	}
	
	public function group($col = '`id`') {
		self::$_sql .= "GROUP BY $col ";
		return self::getInstance();
	}
	
	public function limit() {
		$args = func_get_args();
		if (count($args) == 1) {
			self::$_sql .= "LIMIT {$args[0]}";
		} else if (count($args) > 1) {
			self::$_sql .= "LIMIT {$args[0]}, {$args[1]}";
		} else {
			return false;
		}
		return self::getInstance();
	}
	
	public function exec($returnResult = false) {
		if (preg_match('/select\s+.*from\s+.*/i', self::$_sql)) {
			if ($returnResult) {
				$sql = self::$_sql;
				self::$_sql = '';
				return self::query($sql);
			} else {
				$items = self::fetchAll(self::$_sql);
				self::$_sql = '';
				return $items;
			}
		}
		
		if (self::$_showError) {
			msg::printError('SQL error');
			msg::printMsg(self::$_sql, 'SQL');
		}
		die;
	}
	
	public function toString() {
		if (preg_match('/select\s+.*from\s+.*/i', self::$_sql)) {
			$str = self::$_sql;
			self::$_sql = '';
			return $str;
		}
		if (self::$_showError) {
			msg::printError('SQL error');
			msg::printMsg(self::$_sql, 'SQL');
		}
		die;
	}
	
	public function __toString() {
		return self::toString();
	}
	
	public function update($table, $data, $condition = '1', $replace = null) {
		$sql = "UPDATE `$table` SET ";
		foreach ($data as $field=>$value) {
			$sql .= "`$field` = '" . mysql_real_escape_string($value) . "', ";
		}
		$sql  = rtrim($sql, ', ');
		
		$condition = self::prepare($condition, $replace);
		$sql .= "WHERE $condition";
		return self::query($sql);
	}
	
	public function prepare($stmt, $replace = null) {
		if ($replace !== null || $replace !== false) {
			if (!is_array($replace)) {
				$stmt = str_replace('?', "'" . mysql_real_escape_string($replace) . "'", $stmt);
			} else if ($replace) {
				if (self::_isAssoc($replace)) {
					// Assoc to do
					
					if (self::$_showError) {
						msg::printError('Statement error 2');
					}
					die;
				} else {
					preg_match_all('/\?/', $stmt, $match);
					
					if (count($match[0]) == 1) {
						$tmp = "'" . mysql_real_escape_string($replace[0]) . "' ";
						$stmt = str_replace('?', $tmp, $stmt);
					} else if (count($replace) != count($match[0])) {
						if (self::$_showError) {
							msg::printError('Statement error: cannot bind elements');
						}
						die;
					} else {
						foreach ($replace as $key=>$value) {
							$stmt = preg_replace('/\?/', "'" . mysql_real_escape_string($value) . "'", $stmt, 1);
						}
					}
				}
			}
		}
		return $stmt;
	}
	
	public function fetch($res = null) {
		if (!$res && !is_resource(self::$_query)) {
			return false;
		} else if (is_resource($res)) {
			self::$_query = $res;
		}
		
		if (self::$_fetchMode == self::FETCH_ASSOC) {
			return mysql_fetch_assoc(self::$_query);
		} else if (self::$_fetchMode == self::FETCH_OBJ) {
			return mysql_fetch_object(self::$_query);
		} else if (self::$_fetchMode == self::FETCH_NUM) {
			return mysql_fetch_row(self::$_query);
		}
		return false;
	}
	
	public function setFetchMode($mode = self::FETCH_ASSOC) {
		self::$_fetchMode = $mode;
	}
	
	public function rowCount($res = null) {
		if (!$res && is_resource(self::$_query)) {
			return mysql_num_rows(self::$_query);
		} else if ($res) {
			return mysql_num_rows($res);
		}
		return false;
	}
	
	public function lastInsertId() {
		return mysql_insert_id(self::$_conn);
	}
	
	public function free($res = null) {
		if (!$res && is_resource(self::$_query)) {
			return mysql_free_result(self::$_query);
		} else if ($res) {
			return mysql_free_result($res);
		}
		return false;
	}
	
	public function fetchAll($sql) {
		if ($return = self::_searchCache($sql)) {
			if ($return === true) {
				$return = array();
			}
			return $return;
		}
		self::query($sql);
		$return = array();
		while ($row = self::fetch()) {
			$return[] = $row;
		}
		self::free();
		self::_doCache($sql, $return);
		return $return;
	}
	
	public function count($table, $cond = '', $condParams = array()) {
		if (empty($cond)) { $cond = 1; }
		$stmt   = "SELECT COUNT(*) FROM $table WHERE $cond";
		$sql    = self::prepare($stmt, $condParams);
		$result = self::query($sql);
		return mysql_result($result, 0);
	}
	
	public function execFile($file) {
		if (!file_exists($file)) {
			if (self::$_showError) {
				msg::printError('File does not exist!');
			}
			return false;
		}
		$file = file_get_contents($file);
		$queries = explode(';', $file);
		foreach ($queries as $query) {
			if (!self::query($query)) {
				return false;
			}
		}
		return true;
	}
	
	protected function _isAssoc($array) {
		foreach ($array as $key=>$value) {
			if (is_int($key)) {
				return false;
			}
		}
		return true;
	}
	
	protected function _stripslashesDeep($value) {
		return is_array($value) ? array_map('self::_stripslashesDeep', $value) : strepslashes($value);
	}
}
