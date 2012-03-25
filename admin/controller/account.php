<?php

class accountController extends Controller {
	public function init() {
		$adminDetails = Auth::getAdminDetails();
		$this->tpl->username = $adminDetails['username'];
	}

	public function index() {
		if (Auth::isLogged()) {
			$this->display('profile.tpl');
		} else {
			$returnPoint = get('rp');
			$this->tpl->returnPoint = $returnPoint;
			
			$this->display('login.tpl');
		}
	}
	
	public function do_login() {
		if (!Auth::login($_POST)) {
			message('Utilizatorul sau parola sunt gresite', 'error', 219);
			location(ADMIN_URL . 'account/');
		} else {
			if (!$location = get('rp')) {
				$location = ADMIN_URL;
			}
			location($location);
		}
	}
	
	public function do_profile() {
		if (!Auth::checkPass($_POST['oldpass'])) {
			message('Parola veche este gresita', 'error');
		} else if (!Auth::setNewPassword($_POST)) {
			message('Parolele nu coincid sau contin mai putin de 6 caractere', 'error');
		} else {
			message('Parola a fost schimbata', 'succes');
		}
		location(ADMIN_URL . 'account/profile/');
	}
	
	public function logout() {
		Auth::logout();
		message('Ai fost delogat cu succes', 'succes', 219);
		location(ADMIN_URL . 'account/');
	}
}