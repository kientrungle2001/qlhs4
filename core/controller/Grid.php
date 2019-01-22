<?php
class PzkGridController extends PzkController {
	public $type = 'news';
	
	public function indexAction() {
		$page = pzk_parse($this->getApp()->getPageUri('admin'));
		$page->display();
	}
	
	public function addAction() {
		$page = pzk_parse($this->getApp()->getPageUri('admin'));
			pzk_store_element('left')->append(pzk_parse($this->getUri('add')));
		$page->display();
	}
	
	public function addPost() {
	}
	
	public function edit() {
		$page = pzk_parse($this->getApp()->getPageUri('admin'));
			pzk_store_element('left')->append(pzk_parse($this->getUri('edit')));
		$page->display();
	}
	
	public function editPost() {
	}
	
	public function del() {
	}
	
	public function massDel() {
	}
	
	public function getUri($page) {
		return $this->getApp()->getPageUri('admin/'.$this->type.'/'.$page);
	}
}
?>