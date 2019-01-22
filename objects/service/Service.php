<?php 

/**
* 
*/
class PzkServiceService extends PzkObject
{
    public function loadUserName($member)
  {
    $user=_db()->useCB()->select('user.name as name, user.username as username,user.id as userid, user.avatar as avatar')->from('user')->where(array('id',$member))->result_one();
    //$sql="select `user`.name as 'name' ,`user`.username as 'username' ,`user`.id as 'id',`user`.avatar as 'avatar'  FROM `user` WHERE `user`.id = '".$member."'";
    //$user= _db()->query($sql);
    return $user;

  }
  public function loadService()
  {
      $arr_service= array();
      $service=_db()->useCB()->select('service_packages. *')->from('service_packages')->result();
      //$service=_db()->useCB()->select('user.id as id,user.username as username, friend.userfriend as userfriend')->from('friend')->leftjoin('user','friend.username=user.username')->where(array(array('column','user','id'),'99'))->result();
      foreach ($service as $arr_s) {
        $arr_service[$arr_s['id']]=$arr_s;
      }
      return $arr_service; 
  }
  public function loadDiscount()
  {
      $arr_discount= array();
      $discount=_db()->useCB()->select('service_policy. *')->from('service_policy')->result();
      foreach ($discount as $arr_d) 
      {
        $arr_discount[$arr_d['serviceId']]=$arr_d;
      }
      return $arr_discount; 
  }
 
	
}
 ?>