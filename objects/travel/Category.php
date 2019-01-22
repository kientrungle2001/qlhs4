<?php
class PzkTravelCategory extends PzkObject {
	public $layout = 'travel/category';
	public $rootId = 1;
	public $action = 'vietnamese';
	public function getCategories() {
		$arr = array();
		$level1 = _db()->useCB()->select('*')->from('tourcategory')->where(array('parentId', $this->rootId))->result();
		foreach($level1 as $item) {
			$arr[] = $item;
			$level2 = _db()->useCB()->select('*')->from('tourcategory')->where(array('parentId', $item['id']))->result();
			foreach($level2 as $subitem) {
				$arr[] = $subitem;
			}
		}
		return $arr;
	}
}