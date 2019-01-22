<?php
require_once dirname(__FILE__) . '/PaymentstatTab.php';
class PzkEduPaymentstatPrint extends PzkEduPaymentstatTab {
	public $layout = 'edu/paymentstatPrint';
	public $periodId = false;
	public function getPeriod() {
		$query = _db()->select('*')->from('`payment_period`')->where('id='.$this->periodId)->orderBy('startDate desc');
		$items = $query->result();
		return $items[0];
	}
}