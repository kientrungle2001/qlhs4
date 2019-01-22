<?php 

/**
* 
*/
class PzkUserUser extends PzkObject
{
	public function getRealIPAddress()
	{  
 	if(!empty($_SERVER['HTTP_CLIENT_IP']))
 	{
        //check ip from share internet
   		$ip = $_SERVER['HTTP_CLIENT_IP'];
  	}
  	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  	{
        //to check ip is pass from proxy
   		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  	}
  	else
  	{
   		$ip = $_SERVER['REMOTE_ADDR'];
  	}
  	return $ip;
  	}
	public function loadData()
	{
			
			$username= pzk_session('username');
			$ip=$this->getRealIPAddress();
			pzk_session('userIp',$ip);
			$user=_db()->getEntity('user.user');
			$user->loadWhere(array('username',$username));
			$wallets= $user->getWallets();
			$this->setName($user->getName());
			$this->setAmount($wallets->getAmount());
	}
	
}
 ?>