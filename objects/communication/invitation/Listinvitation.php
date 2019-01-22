<?php 
/**
* 
*/
class PzkCommunicationInvitationListinvitation extends PzkObject
{
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
	public function viewListInvitation()
	{
			
		$items_invi=_db()->useCB()->select('invitation.*')->from('invitation')->where(array('userinvitation',pzk_session('username')))->result();
		return $items_invi; 
	}
	public function testAvatar($avatar)
	{
		
		if($avatar == "")
		{
			$avatar='/3rdparty/uploads/img/noavatar.gif' ;
		}
		
		return $avatar;
		
	}
	public function countinvi()
	{
			
			$username= pzk_session('username');
			$count=_db()->useCB()->select('count(*) as count')->from('invitation')->where(array('userinvitation',$username))->result_one();
			return $count; 
	}
	
}
 ?>