<?php 
/**
* 
*/
class pzkCommunicationFriendFriendlistuser extends PzkObject
{
	public $num_record= 5;
	
	public function loadUserName($member)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
		return $user;
	}
	public function loadUserId($username)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('username',$username))->result_one();
		return $user;
	}
	public function countFriend($member)
	{
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$count=_db()->useCB()->select('count(*) as count')->from('friend')->where(array('username',$username))->result_one();
			return $count; 
	}
	public function numberPage($member)
	{
		$countrow=$this->countFriend($member);
		$num_row= $countrow['count'];
		$num_record= $this->num_record;
        $num_page=ceil($num_row/$num_record);
        return $num_page;
	}
	public function viewListFriend($member)
	{
			
			$loadUserName= $this->loadUserName($member);
			$username= $loadUserName['username'];
			$page=pzk_request('page');
			if(!$page){
				$page=1;
			}
			
			$listfriend=_db()->useCB()->select('friend. *')->from('friend')->where(array('username',$username))->limit($this->num_record,$page-1)->result();
			//$listfriend=_db()->useCB()->select('friend. *')->from('friend')->where(array('username',$username))->result();
			
			//$viewwritewall=_db()->useCB()->select('user_write_wall. *')->from('user_write_wall')->where(array('username',$username))->limit(6,0)->result();
			return $listfriend; 
	}
	public function testOnline($member)
	{
		$sessionID= pzk_session('userId');
		if($member == $sessionID)
		{
			$img='<img src="/3rdparty/uploads/img/online.png" alt=""> Online' ;
		}
		else
		{
			$img='<img src="/3rdparty/uploads/img/offline.png" alt=""> Offline' ;
		}
		 return $img;
		
	}
	public function testAvatar($avatar)
	{
		
		if($avatar == "")
		{
			$avatar='/3rdparty/uploads/img/noavatar.gif' ;
		}
		
		return $avatar;
		
	}



	
}
 ?>