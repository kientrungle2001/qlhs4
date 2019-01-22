<?php
class PzkTravelBreakcrums extends PzkObject {
	public $layout = 'travel/breakcrums';
	public $categoryId = 3;
	public function getCategories() {
		$cats = array();
		$categoryId = $this->categoryId;
		while($categoryId) {
			$up = _db()->useCB()->select('*')->from('tourcategory')
				->where(array('id', $categoryId))
				->result_one();
			$categoryId = $up['parentid'];
			$cats[] = $up;
		}
		return $cats;
	}
}
