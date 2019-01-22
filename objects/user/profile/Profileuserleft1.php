<?php 
/**
* 
*/
class PzkUserProfileProfileuserleft1 extends PzkObject
{
	public function loadUserName($member)
	{
		$ett_user=_db()->getEntity('user.account.user');
		$user= $ett_user->loadWhere(array('id',$member));
		//$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
		return $user;

	}
	public function testMember($member)
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
	public function testAvatar($member)
	{
		$user=$this->loadUserName($member);
		$avatar= $user->getAvatar();
		if($avatar == "")
		{
			$avatar='/3rdparty/uploads/img/noavatar.gif' ;
		}
		
		return $avatar;
		
	}
	public function testFriend($member)
	{
		$sessionUsername= pzk_session('username');

		$user=$this->loadUserName($member);
		$username_member=$user->getUsername();
		$friend= _db()->getEntity('communication.friend');
		$friend->loadWhere(array(array('username',$sessionUsername),array('userfriend',$username_member)));
		if($friend->getId())
		{
			 return true;
		}
		else
		{
			 return false;
		}

	}
	public function testStatus($member)
	{
		
		$sessionID= pzk_session('userId');
		
		// Kiểm tra xem member có phải là bạn với sessionID không?

		if($sessionID == $member)
		{
			return $img='';
		}
		else
		{
			$checkfriend= $this->testFriend($member);
			if($checkfriend)
			{
				return $img='<a href="/communication/denyfriend?member='.$member.'"><img src="/3rdparty/uploads/img/huyketban.png" </a>';
			}
			else
			{
				return $img='<a href="/communication/invitation?member='.$member.'"><img src="/3rdparty/uploads/img/pr_bt_ketban.png" </a>';
			}
		}
		
	}
	public function checkMember($member)
	{
		$sessionID= pzk_session('userId');
		if($member == $sessionID)
		{
			return '<a class="prf_a" href="/user/lessonfavorite?member='.$member.'">Bài học yêu thích</a> ' ;
		}
		else
		{
			 return '<a class="prf_a" href="/user/lessonfavoritemember?member='.$member.'">Bài học yêu thích</a> ' ;
		}
		
		
	}
	
}
 ?>