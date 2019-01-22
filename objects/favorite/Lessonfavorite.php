<?php 
/**
* 
*/
class PzkFavoriteLessonfavorite extends PzkObject
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
	public function countLession($member)
	{
			
			$count=_db()->useCB()->select('count(*) as count')->from('lession_favorite')->where(array('userId',$member))->result_one();
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
	public function viewListLesson($userId,$id)
	{
		
			//$listLesson=_db()->useCB()->select('lesson_favorite.id as id, lessons.lesson_name as lessonName,categories.name as categoriesName, lesson_favorite.date as date')->from('lesson_favorite')->join('categories','categories.id=lesson_favorite.categoriesId')->join('lessons','lessons.id=lesson_favorite.lessonId')->where(array(array('column','lesson_favorite','userId'),$member))->result();
		
			//return $listLesson; 
			$listLesson=_db()->useCB()->select('lesson_favorite.id as id, lessons.lesson_name as lessonName,categories.name as categoriesName, lesson_favorite.date as date')->from('lesson_favorite')->leftjoin('categories','categories.id=lesson_favorite.categoriesId')->leftjoin('lessons','lessons.id=lesson_favorite.lessonId')->where(array('userId',$userId));
			
			if($id) {

				$listLesson->where(array('lt',array('column','lesson_favorite','id'), $id));
			}

			$listLesson->orderBy('lesson_favorite.id desc')->limit(6);
			
			return $listLesson->result(); 
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
	public function countLessonFavorite($userId, $id)
	{
		$countLessonFavorite=_db()->useCB()->select('count(*) as count')->from('lesson_favorite')->where(array('userId',$userId));
		
		if($id)
			{
				$countLessonFavorite->where(array('lt','id', $id));
			}
		$countLessonFavorite->orderBy('id desc');
		$count= $countLessonFavorite->result_one(); 
		return $count['count'];
	}

	
}
 ?>