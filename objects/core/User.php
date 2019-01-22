<?php
class PzkUser extends PzkObject {
	public $model = 'User';
	public $username = false;
	public $userId = false;
	public function init() {
		$this->username = pzk_or(@$this->username, @$_REQUEST['username']);
		$this->userId = pzk_or(@$this->userId, @$_REQUEST['userId']);
	}
	public function loadData() {
		$this->info = $this->model->getUser(pzk_or(@$this->username, @$this->userId));
	}

	public function isFriend($userId) {
		return @$userId && in_array($userId, explode(',', $this->info['friends']));
	}

	public function isMyFriend() {
		return $this->isFriend(_user('id'));
	}

	public function isMyself() {
		$viewingId = $this->getViewingUserId();
		return $viewingId == _user('id');
	}

	public function getPermissions() {
		if (!_user()) return 'public';
		if ($this->isMyself()) return 'private';
		if ($this->isMyFriend())
		return 'friend';
		return 'public';
	}

	public function getViewingUserId() {
		return pzk_or(@_element('owner')->info['id'], _user('id'), -1);
	}

	public function getPermissionsCondition() {
		$viewingId = $this->getViewingUserId();
		$conds = 'userId=' . $viewingId;
		if (!$this->isMySelf()) {
			$conds .= " and (permissions='public'";
			if (_element('owner')->isMyFriend()) {
				$conds .= " or permissions='friend'";
			}
			$conds .= ')';
		}
		return $conds;
	}

	public function doLogout($rq) {
		_session('user', false);
		_route()->redirect('login');
		return true;
	}
}

class PzkAvatar extends PzkObject {
	public $layout = 'avatar';
	public $src = '';
}
?>