<?php
class PzkCoreRewritePermissionErp extends PzkObjectLightWeight {
	public $user = false;
	public $table = 'staff';
	public $entity = 'staff';
	public $username = 'username';
	public $password = 'password';
	public $userId = 'id';
	public $loginFields = array(
		'fullname' => 'NAME',
		'usertype' => 'STAFF_TYPE',
		'username'	=> 'CODE'
	);
	public function init() {
		$request = pzk_element('request');
		$loginId = pzk_session('loginId');
		$controller = $request->get('controller');
		$action = $request->get('action');

		if($controller == 'login' || $action == 'logout' || $action == 'login' || $action == 'loginPost') {
			return ;
		}
		if(!$loginId) {
			header('Location: '.BASE_REQUEST.'/' . pzk_or(@$this->login, 'login')); die();
		}
	}
	
	public function check($controller, $action) {
		if($action == 'login' || $action == 'logout' || $action == 'loginPost') return true;
		return $this->user->getPermission($controller, $action);
	}
	
	public function login($username, $password) {
		$user = _db()->useCB()->select('*')->from($this->table)->where(mand(
			meq($this->username, $username),
			meq($this->password, md5($password))
		));
		$user = $user->result_one();
		if($user) {
			pzk_session('loginId', $user[$this->userId]);
			foreach($this->loginFields as $sessionField => $userField) {
				pzk_session($sessionField, $user[$userField]);
			}
			return true;
		}
		return false;
	}

	public function logout() {
		pzk_session()->setLoginId(NULL);
		foreach($this->loginFields as $sessionField => $userField) {
			pzk_session()->set($sessionField, null);
		}
	}
	
	public function getAllUserTypes() {
		$types = _db()->select('*')->from('profile_type')->result();
		$rs = array();
		foreach($types as $type) {
			$rs[] = $type['name'];
		}
		return $rs;
	}
	public function getAllControllers() {
		$files = glob(pzk_app()->getUri('controller'). '/*');
		$rs = array();
		foreach($files as $file) {
			$parts = explode('/', $file);
			$part = array_pop($parts);
			$parts = explode('.', $part);
			
			$content = file_get_contents($file);
			if(preg_match('/--IGNORE--/', $content)) continue;
			preg_match_all('/([\w]+)Action/', $content, $matches);
			
			$actions = $matches[1];
			preg_match('/[\w]+ extends ([\w]+)/', $content, $match);
			$class = $match[1];
			if($class == 'PzkTableController') {
				$content = file_get_contents('core/controller/Table.php');
				preg_match_all('/([\w]+)Action/', $content, $matches2);
				$actions2 = $matches2[1];
				foreach($actions2 as $action) {
					$actions[] = $action;
				}
			}
			if($class == 'PzkBaseController') {
				$actions[] = 'index';
			}
			
			$rs[] = array('controller' => $parts[0], 'actions' => $actions);
		}
		return $rs;
	}
}