<?php
class PzkTravelTourForeign extends PzkObject {
	public $layout = 'travel/tour/foreign';
	public $categoryId = 7;
	public function getCategory() {
		if($this->categoryId) {
			return _db()->useCB()->select('*')
				->from('tourcategory')
				->where(array('id', $this->categoryId))->result_one();
		}
		return null;
	}
	public function getTours($catId, $pageSize = 10, $pageNo = 0) {
		return _db()->useCB()->select('*')->from('tourdetail')
				->where(array('like', 'categories', '%'.$catId.'%'))
				->limit($pageSize, $pageNo)->result();
	}
	public function getCategories($catId) {
		return _db()->useCB()->select('*')->from('tourcategory')
				->where(array('parentId', $catId))
				->result();
	}
	public function countTours($catId, $pageSize = 10) {
		$total = _db()->useCB()->select('count(*) as c')->from('tourdetail')
				->where(array('like', 'categories', '%'.$catId.'%'))
				->result_one();
		return ceil($total['c'] / $pageSize);
	}
}
