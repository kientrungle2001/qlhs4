<?php
class PzkCoreDbList extends PzkObject {
	public $layout = 'db/list';
	public $layoutType = 'div';
	
	/**
	Cac dieu kien de lay du lieu
	*/
	public $table = 'news';
	public $fields = '*';
	public $conditions = '1';
	public $pageSize = 1000;
	public $pageNum = 0;
	public $pagination = false; // none, ajax
	public $orderBy = 'id asc';
	public $groupBy = false;
	public $having = false;
    public $processReport = false;
    public $status = 1;
    public $exportFields = false;

	/**
	Dieu kien theo parent
	*/
	public $parentId = false;
	public $parentMode = false;
	public $parentField = 'parentId';
	
	/**
	Cac truong can hien thi
	*/
	public $displayFields = 'title,content';
	public $titleTag = 'h3';
	public $contentTag = 'div';
	public $classPrefix = 'core_db_list_item_';
	
	public function init() {
		$this->conditions = json_decode($this->conditions, true);
		if($this->parentMode && $this->parentMode !== 'false') {
			if(!$this->parentId) {
				$request = pzk_element('request');
				$this->parentId = $request->getSegment(3);
			}
			$this->conditions = array('and', $this->conditions, array($this->parentField, $this->parentId));
		}
	}
	
	public function getItems ($keyword = NULL, $fields = array()) {
		$query = _db()->useCB()->select($this->fields)->from($this->table)
				->where($this->conditions)
                //->where($this->status)
				->orderBy($this->orderBy)
				->limit($this->pageSize, $this->pageNum)
				->groupBy($this->groupBy)
				->having($this->having);
		if($keyword && count($fields)) {
			$conds = array('or');
			foreach($fields as $field) {
				$conds[] = array('like', $field, "%$keyword%");
			}
			$query->where($conds);
		}
        $this->prepareQuery($query);
       //echo $query->getQuery();
		return $query->result();
	}

    public function stringQuery ($keyword = NULL, $fields = array()) {
        $select = implode(',', $this->exportFields);
        $query = _db()->useCB()->select($select)->from($this->table)
            ->where($this->conditions)
            ->orderBy($this->orderBy)
            ->limit($this->pageSize, $this->pageNum)
            ->groupBy($this->groupBy)
            ->having($this->having);
        if($keyword && count($fields)) {
            $conds = array('or');
            foreach($fields as $field) {
                $conds[] = array('like', $field, "%$keyword%");
            }
            $query->where($conds);
        }
        $this->prepareQuery($query);
        return $query->getQuery();
    }

    public function addFilter($index, $condition) {
        $this->conditions .= " and {$index} like '%{$condition}%'";
    }

	
	public function getCountItems($keyword = NULL, $fields = array()) {
		$row = _db()->useCB()->select('count(*) as c')
				->from($this->table)
				->where($this->conditions)
				->groupBy($this->groupBy)
				->having($this->having);
		if($keyword && count($fields)) {
			$conds = array('or');
			foreach($fields as $field) {
				$conds[] = array('like', $field, "%$keyword%");
			}
			$row->where($conds);
		}
        $this->prepareQuery($row);
        $row = $row->result_one();
		return $row['c'];
	}

    public function prepareQuery($query) {

    }

    public function getNameById($id, $table, $field) {
        $data = _db()->useCB()->select('*')->from($table)->where(array('id', $id))->result_one();
        return $data[$field];
    }
}