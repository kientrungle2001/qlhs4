<?php
class PzkEcomBillingDetail extends PzkObject {
	public $orderId;
	public function getOrder() {
		return _db()->select('*')->from('billing_order')->where(array('id' => $this->orderId))->result_one();
	}
}