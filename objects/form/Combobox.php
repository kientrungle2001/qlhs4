<?php
class PzkFormCombobox extends PzkObject {
	public $sql = false;
	public function loadData() {
		if($this->sql) {
			$this->items = _db()->query($this->sql);
		}
	}
}
?>