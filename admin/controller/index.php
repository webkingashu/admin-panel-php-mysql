<?php

class indexController extends Controller {

	public function index() {
		
		$items = DB::select('a.id, a.username, al.ip, al.date')
			->from(Auth::getAdminsTable() . ' a JOIN ' . Auth::getAdminsLogTable() . ' al ON(al.admin_id=a.id)')
			->order('`date` DESC')
			->limit(10)
			->exec();
		$this->tpl->userLog = $items;
		
		$this->display('index.tpl');
	}
	
	public function error404() {
		echo '<h1>Error 404!</h1>';
	}
}