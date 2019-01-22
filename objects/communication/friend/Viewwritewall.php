<?php 
/**
* 
*/
class PzkCommunicationFriendViewwritewall extends PzkObject
{
	public function loadUserID($username)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('username',$username))->result_one();
		//$sql="select `user`.name as 'name' ,`user`.username as 'username' ,`user`.id as 'id',`user`.avatar as 'avatar'  FROM `user` WHERE `user`.id = '".$member."'";
		//$user= _db()->query($sql);
		return $user;

	}
	public function loadUserName($member)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
		return $user;
	}
	public function viewWriteWall($member)
	{
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$page=pzk_request('page_wall');
			if(!$page){
				$page=1;
			}
			
			$viewwritewall=_db()->useCB()->select('user_write_wall. *')->from('user_write_wall')->where(array('username',$username))->limit(6,$page-1)->result();
			//$viewwritewall=_db()->useCB()->select('user_write_wall. *')->from('user_write_wall')->where(array('username',$username))->limit(6,0)->result();
			return $viewwritewall; 
	}
	public function countWriteWall($member)
	{
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$count=_db()->useCB()->select('count(*) as count')->from('user_write_wall')->where(array('username',$username))->result_one();
			return $count; 
	}
	public function numberPage($member)
	{
		$countWriteWall= $this->countWriteWall($member);
		$num_row= $countWriteWall['count'];
		$num_record= 6;
        $num_page=ceil($num_row/$num_record);
        //var_dump($countWriteWall);
        //die();
        return $num_page;
	}

}
 ?>