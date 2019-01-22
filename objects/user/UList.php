<?php
require_once BASE_DIR . '/objects/List.php';
class PzkUList extends PzkList {
	public function init() {
		parent::init();
		$this->conditions = _element('owner')->getPermissionsCondition();
		$this->canEdit = _element('owner')->isMyself();
	}
}
?>