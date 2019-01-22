<?php 
/**
* 
*/
class PzkUserProfileuserleft extends PzkObject
{
	public function loadNote()
	{
			$request=pzk_element('request');
			$username=pzk_session('username');
			$sql=" select * from `user_note` where username='".$username."' order by id asc limit 8 ";
			$note= _db()->query($sql);
			return ($note); 
	}
	// Hiển thị tất cả các
	public function loadWriteWall()
	{
			$request=pzk_element('request');
			$username=pzk_session('username');
			$sql=" select * from `user_write_wall` where username='".$username."' order by id asc limit 8 ";
			$write_wall= _db()->query($sql);
			return ($write_wall); 
	}
}
 ?>