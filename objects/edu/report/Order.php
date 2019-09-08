<?php
class PzkEduReportOrder extends PzkObject {
	public $layout = 'edu/report/order';
	public $startDate;
	public $endDate;
	public function getOrders() {
		$conds = array('and', array('student_order.status', ''), 
					array('gte', 'student_order.created', $this->startDate), 
					array('lte','student_order.created', $this->endDate) );
		if(@$this->subjectId) {
			$conds[] = array('classes.subjectId', $this->subjectId);
		}
		if(''.@$this->payment_type !== '') {
			$conds[] = array('`student_order`.`paymentType`', $this->payment_type);
		}

		// $query = _db()->useCB()->select('*')->from('general_order')->where($conds)->orderBy('created asc');
		$query = _db()->useCB()
			->select('student_order.*,classes.name as className')
			->from('student_order')
			->join('general_order', 'student_order.orderId=general_order.id')
			->join('classes', 'student_order.classId=classes.id')
			->where($conds)
			->orderBy('student_order.created asc');
		return $query->result();
	}
}