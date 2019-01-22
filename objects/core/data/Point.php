<?php
class PzkCoreDataPoint extends PzkObject {
	public $table = false;
	public $fields = '*';
	public $conds = '1';
	public $orderBy = 'id asc';
	public $entity = false;
	public $idKey = true;
	public $data = false;
	public function init() {
		$data = _db()->useCB()->select($this->fields)->from($this->table)->where($this->conds)->result($this->entity);
		if($this->idKey) {
			$this->data = array();
			foreach($data as $item) {
				$this->data[$item['id']] = $item;
			}
		} else {
			$this->data = $data;
		}
	}
}
function pzk_data($id) {
	return pzk_element($id)->data;
}