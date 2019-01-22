<?php
require_once 'Tree.php';
class MenuModel extends TreeModel {
	public function getMenu () {
		return $this->getTree('Menu', 'disable<>1');
	}
}
?>