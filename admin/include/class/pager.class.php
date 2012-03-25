<?php

class Pager {
	
	protected $_html = '';
	
	public function __construct($params) {
		$params['page']    = empty($params['page']) ? 1 : $params['page'];
		$params['total']   = empty($params['total']) ? 0 : $params['total'];
		$params['limit']   = empty($params['limit']) ? 0 : $params['limit'];
		$params['pattern'] = empty($params['pattern']) ? '' : $params['pattern'];
		$this->init($params);
	}
	
	public function init($params) {
		$totalPages = ceil($params['total'] / $params['limit']);
		if ($totalPages == 1) {
			return true;
		}
		
		$start = 1; // ($params['page'] - 3) < 1 ? 1 : ($params['page'] - 3);
		$stop  = $totalPages; // ($params['page'] + 3) > $totalPages ? $totalPages : ($params['page'] + 3);
		
		$this->_html = '<ul class="pager">';
		for ($i = $start;$i <= $stop;$i++) {
			$li = '<li class="{CLASS}"><a href="' . $params['pattern'] . '">' . $i . '</a></li>';
			$search = array(
				'{PAGE}'  => $i,
				'{CLASS}' => $i == $params['page'] ? 'current' : 'page',
			);
			$this->_html .= str_replace(array_keys($search), array_values($search), $li);
		}
		$this->_html .= '</ul>';
	}
	
	public function __toString() {
		return $this->_html;
	}
}