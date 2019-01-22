<?php 
/**
* 
*/
class PzkCommunicationFriendDetailnote extends PzkObject
{
	public function loadUserName($member)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
	
		return $user;

	}
	public function countComment($noteId)
	{
			
			$count=_db()->useCB()->select('count(*) as count')->from('user_note_comment')->where(array('noteId',$noteId))->result_one();
			return $count; 
	}
	public function checkAvatar($member)
	{
		//$user=_db()->useCB()->select('user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
		$user=$this->loadUserName($member);
		$avatar=$user['avatar'];
		if($avatar=="")
		{
			return '<img src="/3rdparty/uploads/img/noavatar.gif"  alt="" width="60" height="60">';
		}
		else
		{
			return '<img src="'.$avatar.'"  alt="" width="60" height="60">';
		}


	}
	public function loadUserID($username)
	{
		$user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('username',$username))->result_one();
	
		return $user;

	}
	public function loadDetailNote($id)
	{
			
			$note=_db()->useCB()->select('user_note.*')->from('user_note')->where(array('id',$id))->result_one();
			return $note; 
	}
	// Hiển thị tất cả các các comment
	public function loadCommentNote($noteId,$id)
	{
			
			$page=pzk_request('page');
			if(!$page){
				$page=1;
			}
			$comment_note=_db()->useCB()->select('user_note_comment.*')->from('user_note_comment')
				->where(array('noteId',$noteId));
			if($id)
			{
				$comment_note->where(array('lt','id', $id));
			}
			

			$comment_note->orderBy('id desc')->limit(6,0);
			
			return $comment_note->result(); 
			//var_dump($comment_note->result());
			//die();
	}
	public function countCommentNote($noteId, $id)
	{
		$count_comment=_db()->useCB()->select('count(*) as count')->from('user_note_comment')->where(array('noteId',$noteId));
		if($id)
			{
				$count_comment->where(array('lt','id', $id));
			}
			

			$count_comment->orderBy('id desc');
			
			$count= $count_comment->result_one(); 
			return $count['count'];
	}

}
 ?>