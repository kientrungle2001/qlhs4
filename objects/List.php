<?phpclass PzkList extends PzkObject {	public $layout = 'list';	public $model = 'Table';
	public $sql = false;
	public $countSql = false;
	public $rowsCount = 10;
	public $pageCount = false;
	public $filters = false;	public $evaling = false;
	public function loadData() {
		require_once BASE_DIR . '/lib/arr.php';		require_once BASE_DIR . '/lib/condition.php';
		if ($this->sql && $this->sql != 'false') {
			$this->items = _db()->query($this->sql);
		} else {			$this->items = $this->model->getItems(array(				'fields' => pzk_or(@$this->fields, 'id,title,brief,content'), 				'table' => pzk_or(@$this->table, 'News'), 				'pageSize' => pzk_or(@$this->pageSize, 10),				'pageNum' => pzk_or(@$this->pageNum, 0),				'conditions' => sql_parse_exp(pzk_or(@$this->condition, '1'), @$this->evaling),				'orderBy' => pzk_or(@$this->orderBy, false),				'groupBy' => pzk_or(@$this->groupBy, false),				'filters' => pzk_or($this->filters, false)
			));
			$this->itemsCount = $this->model->countItems(array(
				'fields' => pzk_or(@$this->fields, 'id,title,brief,content'), 
				'table' => pzk_or(@$this->table, 'News'), 
				'conditions' => pzk_or(@$this->condition, '1'),
				'groupBy' => pzk_or(@$this->groupBy, false),
				'filters' => pzk_or($this->filters, false),
			));
			
		}
		if ($this->countSql && $this->countSql != 'false') {
			$this->itemsCount = db_get($this->countSql, 'c');
		}
		if (@$this->itemsCount) {
			$this->pageCount = ceil($this->itemsCount / pzk_or(@$this->pageSize, @$this->rowsCount));		}
	}}