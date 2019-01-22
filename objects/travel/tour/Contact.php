<?php
class PzkTravelTourContact extends PzkObject {
	public $layout = 'travel/tour/contact';
	public $tourId = false;
	public function getTour() {
		return _db()->useCB()->select('*')->from('tourdetail')
			->where(array('id', $this->tourId))->result_one();
	}
}