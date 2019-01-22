<?php
class PzkTravelFeature extends PzkObject {
	public $layout = 'travel/feature';
	public function getTours() {
		$tours = _db()->useCB()->select('*')
		->from('tourdetail')
		->where(array('feature', 1))
		->limit(4, 0)->result();
		return $tours;
	}
}
