<?php 

/**
* 
*/
class PzkPaymentPayment extends PzkObject
{
	public function PaymentNganLuong()
	{

	   require(BASE_DIR.'/3rdparty/nganluong/include/nganluong.microcheckout.class.php');
    	require(BASE_DIR.'/3rdparty/nganluong/include/lib/nusoap.php');
    	require(BASE_DIR.'/3rdparty/nganluong/config.php');
    	$inputs = array(
    					'receiver'    => RECEIVER,
    					'order_code'  => 'username : '.pzk_session('username').'DH : '.date("Y-m-d H:i:s"),
    					'return_url'  => BASE_URL.'/payment/confirmpayment',
    					'cancel_url'  => BASE_URL.'/payment/payment',
    					'language'    => 'vn'
    					);
    	$link_checkout = '';
    	$obj = new NL_MicroCheckout(MERCHANT_ID, MERCHANT_PASS, URL_WS);
    	$result = $obj->setExpressCheckoutDeposit($inputs);

    	if ($result != false) 
    	{	
      		if ($result['result_code'] == '00') 
      		{
        		$token_key = $result['token'];
        		$link_checkout = $result['link_checkout'];
        		$link_checkout = str_replace('micro_checkout.php?token=', 'index.php?portal=checkout&page=micro_checkout&token_code=', $link_checkout);
       			 $link_checkout .='&payment_option=nganluong';
        		return $link_checkout;

      		} 
      		else 
      		{
        		//die('Ma loi '.$result['result_code'].' ('.$result['result_description'].') ');
        		return $result['result_description'];
      		}
    	}
    	else
    	{
    		$error= 'Loi ket noi toi cong thanh toan ngan luong';
    		return $error;
    	}
 
	}
}
 ?>