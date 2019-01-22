<?php
require_once dirname(__FILE__) . '/OrderstatTab.php';
class PzkEduOrderstatPrint extends PzkEduOrderstatTab {
	public $layout = 'edu/orderstatPrint';
	public $periodId = false;
	public function getPeriod() {
		$query = _db()->select('*')->from('`payment_period`')->where('id='.$this->periodId)->orderBy('startDate desc');
		$items = $query->result();
		return $items[0];
	}
}