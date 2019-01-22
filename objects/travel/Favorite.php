<?php
class PzkTravelFavorite extends PzkObject {
	public $layout = 'travel/favorite';
	public $categoryId = 3;
	public function getTours() {
		$tours = _db()->useCB()->select('*')
		->from('tourdetail')
		->where(array('favorite', 1))
		->where(array('like', 'categories', '%'.$this->categoryId.'%'))
		->limit(10, 0)->result();
		return $tours;
	}
}
