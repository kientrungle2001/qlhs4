<?php
class PzkCoreDatabaseTable extends PzkObjectLightWeight {
	private $table = '';
	public function table($table) {
		$this->table = $table;
		return $this;
	}
	public function get($id) {
		return _db()->select('*')->from($this->table)->where('id=' . $id)->result_one();
	}
	public function children($id, $type = false, $subType = false) {
		return _db()->select('*')->from($this->table)
				->where('parentId=' . $id . ($type ? " and `type`='$type'": "") . 
									($subType ? " and `subType`='$subType'": ""))->result();
	}
	public function set($id, $data) {
		return _db()->update($this->table)->set($data)->where('id='.$id)->result();
	}
	public function insert($data) {
		return _db()->insert($this->table)->fields(implode(',', array_keys($data)))->values($data)->result();
	}
	
	public function getInstance(){
		return new PzkCoreDatabaseTable(array());
	}
}

function db_table($table) {
	return pzk_element('dbtable')->getInstance()->table($table);
}