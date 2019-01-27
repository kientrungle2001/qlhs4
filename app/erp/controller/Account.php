<?php
class PzkAccountController extends PzkController {
	public function loginAction() {
		$this->getStructure('login')->display();
	}
	public function loginPostAction() {
		$permission = pzk_element()->getPermission();
		
		if($permission->login(pzk_request()->getUsername(), pzk_request()->getPassword())) {
			$this->redirect('home/index');
		} else {
			$this->redirect('/account/login');
		}
	}

	public function logoutAction() {
		$permission = pzk_element()->getPermission();
		$permission->logout();
		$this->redirect('/account/login');
	}
}