<?php
class PzkTravelSearchbox extends PzkObject {
	public $layout = 'travel/searchbox';
	public function getDepartures() {
		return _db()->select('*')->from('tourdeparture')->result();
	}
	public function getDestinations() {
		return _db()->select('*')->from('tourdestination')->result();
	}
	public function getDurations() {
		return _db()->select('*')->from('tourduration')->result();
	}
}