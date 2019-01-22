<?php
require_once dirname(__FILE__) . '/MusterTab.php';
class PzkEduMusterPrint extends PzkEduMusterTab {
	public $layout = 'edu/musterPrint';
	public $periodId = false;
	public function getPeriod() {
		$query = _db()->select('*')->from('`payment_period`')->where('id='.$this->periodId)->orderBy('startDate desc');
		$items = $query->result();
		return $items[0];
	}
}