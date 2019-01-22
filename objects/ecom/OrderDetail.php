<?php
class PzkEcomOrderDetail extends PzkObject {
	public $orderId;
	public function getOrder() {
		return _db()->select('*')->from('general_order')->where('id='. $this->orderId)->result_one();
		if($order) {
			$this->classId = $order[0]['classId'];
			$this->studentId = $order[0]['studentId'];
			$this->periodId = $order[0]['payment_periodId'];
			return $order[0];
		}
	}
}