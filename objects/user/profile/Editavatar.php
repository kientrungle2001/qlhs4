<?php 

/**
* 
*/
class PzkUserProfileEditavatar extends PzkObject
{
	public function loadAvatar()
	{
		$user=_db()->getEntity('user.account.user');
		$user->loadWhere(array('username',pzk_session('username')));
		return $user;
	}
	
}

 ?>