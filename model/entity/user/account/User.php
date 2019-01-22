<?php 
/**
* 
*/
class PzkEntityUserAccountUserModel extends PzkEntityModel
{
	public $table="user";
	public function getWallets()
	{
		$wallets=_db()->getEntity('user.account.wallets');
		$wallets->loadWhere(array('username',$this->getUsername()));
		return $wallets;
	}
}
 ?>