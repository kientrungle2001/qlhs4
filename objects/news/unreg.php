<?php 

/**
* 
*/
class PzkNewsUnreg extends PzkObject
{

		public function getDelMail($key,$email) 
			{
			 $key2 = md5($email.'nn123456');
			 if($key==$key2)
				{
					$id=_db()->useCB()->select('id')->from('mail')->where(array('mail',$email))->result_one();
					_db()->delete()->from('mail')->where('id='.$id['id'])->result();
				}
			}
		
}

?>