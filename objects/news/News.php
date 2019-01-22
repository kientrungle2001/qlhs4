<?php 

/**
* 
*/
class PzkNewsNews extends PzkObject
{
	
	public function getNews()
	{
		$titles=_db()->useCB()->select("*")->from("news")->where(array('parent','0'))->result();
		return($titles);
	}
	public function getSubnews($id)
	{
		$titles2=_db()->useCB()->select("*")->from("news")->where(array('parent',$id))->limit(5)->result();
		return($titles2);
	}
	
	
}
 ?>