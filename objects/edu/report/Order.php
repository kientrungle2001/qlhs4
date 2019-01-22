<?php
class PzkEduReportOrder extends PzkObject {
	public $layout = 'edu/report/order';
	public $startDate;
	public $endDate;
	public function getOrders() {
		$conds = array('and', array('status', ''), 
					array('gte', 'created', $this->startDate), 
					array('lte','created', $this->endDate) );
		if(@$this->subject) {
			$conds[] = array('like', 'reason', '%' . $this->subject . '%');
		}
		if(@$this->notsubject) {
			$conds[] = array('notlike', 'reason', '%' . $this->notsubject . '%');
		}
		$query = _db()->useCB()->select('*')->from('general_order')->where($conds)->orderBy('created asc');
		return $query->result();
	}
}