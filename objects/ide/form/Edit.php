<?php
class PzkIdeFormEdit extends PzkObject {
	public $itemId = false;
	public $table = 'profile_resource';
	public $item = false;
	public $fields = '*';
	public function getItem() {
		if(!$this->item) {
			$item = _db()->select($this->fields)->from($this->table)->where('id=' . $this->itemId)->result_one();
			$this->item = $item;
		}
		return $this->item;
	}
	
}