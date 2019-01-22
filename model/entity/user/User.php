<?php 
/**
* 
*/
class PzkEntityUserUserModel extends PzkEntityModel
{
	public $table="user";
	public function getWallets()
	{
		$wallets=_db()->getEntity('user.wallets');
		$wallets->loadWhere(array('username',$this->getUsername()));
		return $wallets;
	}
}
 ?>