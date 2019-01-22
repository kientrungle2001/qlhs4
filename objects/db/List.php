<?php
class PzkDbList extends PzkObjectLightWeight {
	public $layout = 'db/list';
	public $table = 'news';
	public $fields = '*';
	public $conditions = '1';
	public $pageSize = 1000;
	public $pageNum = 1;
	public $pagination = false; // none, ajax
	public $orderBy = 'id asc';
	public $groupBy = false;
	
	public function display() {
		return PzkParser::parseLayout($this->layout, $this, true);
	}
	
	public function getItems () {
		return _db()->select($this->fields)->from($this->table)
				->where($this->conditions)
				->limit($this->pageSize, $this->pageNum)
				->groupBy($this->groupBy)
				->result();
	}
	
	public function getCountItems() {
		$rows = _db()->select('count(*) as c')
				->from($this->table)
				->where($this->conditions)
				->filters(false)
				->groupBy(false)->result();
		if ($rows) {
			return $rows[0]['c'];
		}
		return 0;
	}
}