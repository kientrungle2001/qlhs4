<?php
class PzkCoreDbTree extends PzkObject {
	public $layout = 'core/db/tree';
	public $table = false;
	public function getItems() {
		return _db()->useCB()->select('*')->from($this->table)->result();
	}
}