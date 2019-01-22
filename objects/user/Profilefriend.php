<?php 
/**
* 
*/
class PzkUserProfilefriend extends PzkObject
{
	// Hiển thị tất cả các ghi chép cá nhân
	public function loadNote()
	{
			$request=pzk_element('request');
			$username=$request->get('member');
			$sql=" select * from `user_note` where username='".$username."' order by id asc limit 8 ";
			$note= _db()->query($sql);
			return ($note); 
	}
	// Hiển thị tất cả các
	public function loadWriteWall()
	{
			$request=pzk_element('request');
			$username=$request->get('member');
			$sql=" select * from `user_write_wall` where username='".$username."' order by id asc limit 8 ";
			$write_wall= _db()->query($sql);
			return ($write_wall); 
	}
}
 ?>