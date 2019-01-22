<?php 
/**
* 
*/
class PzkUserProfileProfileusercontent extends PzkObject
{
	public function loadUserName($member)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
	
		return $user;

	}
	public function loadUserID($username)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('username',$username))->result_one();
	
		return $user;

	}
	public function loadNote($member)
	{
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$note=_db()->useCB()->select('user_note.*')->from('user_note')->where(array('username',$username))->limit(6,0)->result();
			return $note; 
	}
	// Hiển thị tất cả các
	public function loadWriteWall($member)
	{
			
			//$username=pzk_session('username');
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$write_wall=_db()->useCB()->select('user_write_wall.*')->from('user_write_wall')->where(array('username',$username))->limit(6,0)->result();
			
			return $write_wall; 
	}

}
 ?>