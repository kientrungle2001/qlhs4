<?php 
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityNewsModel extends PzkEntityModel {
	public $table = 'news';
	public function getAuthor() {
		$author = _db()->getEntity('user');
		$author->load($this->getUserId());
		return $author;
	}
}