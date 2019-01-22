<?php
class PzkCoreDbDetail extends PzkObject {
	/**
	Bang can lay du lieu
	*/
	public $table = 'News';
	
	/**
	id cua ban ghi can lay
	*/
	public $itemId = false;
	
	/**
	Cac truong can lay
	*/
	public $fields = '*';
	
	/**
	Giao dien
	*/
	public $layout = 'db/detail';
	
	/**
	Entity model
	*/
	public $entity = false;
	
	/**
	Co comment facebook khong
	*/
	public $facebookComment = false;
	
	/**
	Cau hinh cac truong can hien thi
	*/
	public $displayFields = 'title,content';
	
	/**
	Cau hinh tag cho tung truong
	*/
	public $titleTag = 'h2';
	public $contentTag = 'div';
	
	/**
	Class prefix cho cac truong
	*/
	public $classPrefix = 'core_db_';
	
	/**
	Co hien thi hinh anh khong
	*/
	public $showImages = false;
	/**
	Co hien thi tin tuc lien quan khong
	*/
	public $showRelateds = false;
	/**
	Tin tuc lien quan dua vao truong
	*/
	public $relatedFields = 'categories';
	
	/**
		Co cau tra loi khong
	*/
	public $hasAnswer = false;
	
	/**
		Lay du lieu
	*/
	public function getItem() {
		if(!$this->itemId) {
			$request = pzk_element('request');
			$this->itemId = $request->getSegment(3);
		}
		return _db()->useCB()->select($this->fields)->from($this->table)
				->where(array('id', $this->itemId))->result_one($this->entity);
	}
	
	/**
	Lay ban ghi truoc
	*/
	public function getPrevItem($conds = false) {
		return _db()->useCB()->select($this->fields)->from($this->table)
				->where(array('and', array('gt', 'id', $this->itemId), $conds) )->result_one($this->entity);
	}
	
	/**
	Lay ban ghi ke tiep
	*/
	public function getNextItem($conds = false) {
		return _db()->useCB()->select($this->fields)->from($this->table)
				->where(array('and', array('lt', 'id', $this->itemId), $conds))->result_one($this->entity);
	}
}
?>