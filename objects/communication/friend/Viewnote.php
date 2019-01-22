<?php 
/**
* 
*/
class PzkCommunicationFriendViewnote extends PzkObject
{
	public function loadUserName($member)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
		//$sql="select `user`.name as 'name' ,`user`.username as 'username' ,`user`.id as 'id',`user`.avatar as 'avatar'  FROM `user` WHERE `user`.id = '".$member."'";
		//$user= _db()->query($sql);
		return $user;

	}
	public function viewNote($member)
	{
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$page=pzk_request('page');
			if(!$page){
				$page=1;
			}
			$viewnote=_db()->useCB()->select('user_note. *')->from('user_note')->where(array('username',$username))->limit(10,$page-1)->result();
			return $viewnote; 
	}
	public function countNote($member)
	{
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$count=_db()->useCB()->select('count(*) as count')->from('user_note')->where(array('username',$username))->result_one();
			return $count; 
	}
}
?>