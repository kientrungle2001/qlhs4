<?php

class PzkTableController extends PzkController {

    public $tables = array();
    public $inserts = array();
    public $constraints = array();
    public $filters = array();
	public $deletes = array();
	public $statusDeletes = array();

    public function jsonAction() {
        $table = @$_REQUEST['table'];
		$oldTable = $table;
        $fields = @$this->tables[$table] ? @$this->tables[$table] : '*';
        $filters = @$this->filters[$table];
		$cbFilters = @$this->filters[$table . '_filter'];
        $groupBy = false;
		$defaultOrderBy = false;
		$arrFields = array();
		$defaultConds = '1';
		if (is_array($fields)) {
			$arrFields = $fields;
            $table = @$fields['table']?$fields['table']: $oldTable;
            $groupBy = isset($fields['groupBy']) ? $fields['groupBy'] : false;
			$defaultOrderBy = isset($fields['groupBy']) ? $fields['groupBy'] : false;
			$defaultConds = isset($fields['conds']) ? $fields['conds'] : '1';
			$fields = @$fields['fields']?@$fields['fields']: '*';
        }
        $conds = array();
		$havingConds = array();
		$cbWhereConds = false;
		$cbHavingConds = false;
        if (isset($_REQUEST['filters'])) {
            if (!$filters) {
                $conds = array_merge($conds, $_REQUEST['filters']);
            } else {
                foreach ($filters as $key => $options) {
					if(!isset($_REQUEST['filters'][$key]) || isset($_REQUEST['filters'][$key]) && $_REQUEST['filters'][$key] == '') continue;
                    foreach ($options as $comp => $field) {
						if(is_array($field)) {
							if(isset($field['having']) && $field['having'] == true) {
								$havingConds[] = array($field['name'] => array('cp' => $comp, 'value' => @$_REQUEST['filters'][$key]));
							}
						} else {
							if (!!@$_REQUEST['filters'][$key]) {
								$conds[] = array($field => array('cp' => $comp, 'value' => @$_REQUEST['filters'][$key]));
							}
						}
                    }
                }
            }
			
			if ($cbFilters) {
				if(isset($cbFilters['where'])) {
					foreach ($cbFilters['where'] as $key => $options) {
						if(!isset($_REQUEST['filters'][$key]) || isset($_REQUEST['filters'][$key]) && $_REQUEST['filters'][$key] == '') continue;
						if(!$cbWhereConds) {
							$cbWhereConds = array('and', 
								array('equal', array('string', '1'), array('string', '1')), 
								array('equal', array('string', '1'), array('string', '1')));
						}
						$options = json_encode($options);
						$options = str_replace('?', $_REQUEST['filters'][$key], $options);
						$options = json_decode($options, true);
						$cbWhereConds[] = $options;
					}
				}
				if(isset($cbFilters['having'])) {
					foreach ($cbFilters['having'] as $key => $options) {
						if(!isset($_REQUEST['filters'][$key]) || isset($_REQUEST['filters'][$key]) && $_REQUEST['filters'][$key] == '') continue;
						if(!$cbHavingConds) {
							$cbHavingConds = array('and', 
								array('equal', array('string', '1'), array('string', '1')), 
								array('equal', array('string', '1'), array('string', '1')));
						}
						$options = json_encode($options);
						$options = str_replace('?', $_REQUEST['filters'][$key], $options);
						$options = json_decode($options, true);
						$cbHavingConds[] = $options;
					}
				}
			}
        }
        $rows = @$_REQUEST['rows'] ? @$_REQUEST['rows'] : 50;
        $page = @$_REQUEST['page'] ? @$_REQUEST['page'] : 1;
        $total = _db()->select($fields . ', count(*) as val')->from($table);
		$total->where($defaultConds)
                        ->where($conds);
		
		if($groupBy) {
			$total = $total->groupBy($groupBy);
		}
		if(count($havingConds)) {
			$total->having($havingConds);
		}
		
		if($cbWhereConds || $cbHavingConds) {
			$total->useCB();
			if($cbWhereConds) {
				$total->where($cbWhereConds);
			}
			if($cbHavingConds) {
				$total->having($cbHavingConds);
			}
		}
		$totalQuery = $total->getQuery();
		if($groupBy) {
			$tt = _db()->select('count(*) as val')->from('('.$totalQuery . ') as s');
			$total = $tt->result();
		} else {
			$total = $total->result();
		}
        $orderBy = array();
        $sort = explode(',', @$_REQUEST['sort']);
        $order = explode(',', @$_REQUEST['order']);
        foreach ($sort as $index => $val) {
            $orderBy[] = $sort[$index] . ' ' . $order[$index];
        }
        $orderBy = implode(',', $orderBy);
        if (!trim($orderBy)) {
            $orderBy = $defaultOrderBy ? $defaultOrderBy: 'id desc';
        }
        $items = _db()
                        ->select($fields)
                        ->from($table)
						->where($defaultConds)
                        ->where($conds)
                        ->orderBy($orderBy)
                        ->limit($rows, ($page - 1));
		if($groupBy) {
			$items = $items->groupBy($groupBy);
		}
		if(count($havingConds)) {
			$items->having($havingConds);
		}
		if($cbWhereConds || $cbHavingConds) {
			$items->useCB();
			if($cbWhereConds) {
				$items->where($cbWhereConds);
			}
			if($cbHavingConds) {
				$items->having($cbHavingConds);
			}
		}
		$query = $items->getQuery();
		$items = $items->result();
        $data = array(
            'total' => $total[0]['val'],
            'rows' => $items,
			'groupBy' => $groupBy,
			'fields' => $arrFields,
			'query' => $query,
			'totalQuery' => $totalQuery
        );
        echo json_encode($data);
    }
	
	public function treejsonAction() {
		//$_REQUEST['showSQL'] = 1;
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$table = @$_REQUEST['table'];
        $fields = @$this->tables[$table] ? @$this->tables[$table] : '*';
        $filters = @$this->filters[$table];
        if (is_array($fields)) {
            $table = $fields['table'];
            $fields = $fields['fields'];
        }
        $conds = array();
		$conds[] = "parentId=$id";
        $rows = @$_REQUEST['rows'] ? @$_REQUEST['rows'] : 1000;
        $page = @$_REQUEST['page'] ? @$_REQUEST['page'] : 1;
        $total = _db()->select('count(*) as val')->from($table)->where($conds)->result();
        $orderBy = array();
        $sort = explode(',', @$_REQUEST['sort']);
        $order = explode(',', @$_REQUEST['order']);
        foreach ($sort as $index => $val) {
            $orderBy[] = $sort[$index] . ' ' . $order[$index];
        }
        $orderBy = implode(',', $orderBy);
        if (!trim($orderBy)) {
            $orderBy = 'id desc';
        }
        $items = _db()
                        ->select($fields)
                        ->from($table)
                        ->where($conds)
                        ->orderBy($orderBy)
                        ->limit($rows, ($page - 1))->result();
		foreach($items as &$item) {
			if($this->_hasChild($table, $item['id'])) {
				$item['state'] = 'closed';
			} else {
				$item['state'] = 'open';
			}
		}
        $data = array(
            'total' => $total[0]['val'],
            'rows' => $items
        );
        echo json_encode($items);
	}
	
	public function _hasChild($table, $id) {
		$rs = mysql_query("select count(*) from `$table` where parentId=$id");
		$row = mysql_fetch_array($rs);
		return $row[0] > 0 ? true : false;
	}

    public function editAction() {
        $table = @$_REQUEST['table'];
        $fields = @$this->inserts[$table] ? @$this->inserts[$table] : array();
        $data = array();
        foreach ($fields as $field) {
            if (isset($_REQUEST[$field])) {
                $data[$field] = $_REQUEST[$field];
            }
        }
        _db()->update($table)
                ->set($data)->where('id=' . $_REQUEST['id'])->result();
        echo json_encode(array(
            'errorMsg' => false
        ));
    }

    public function addAction() {
        $table = @$_REQUEST['table'];
        $fields = @$this->inserts[$table] ? @$this->inserts[$table] : array();
        $data = array();
        foreach ($fields as $field) {
            if (isset($_REQUEST[$field])) {
                $data[$field] = urldecode($_REQUEST[$field]);
            }
        }
        if ($result = $this->checkConstraints($table, $data)) {
            echo json_encode(array(
                'errorMsg' => $result['message']
            ));
            return false;
        }
        _db()->insert($table)
                ->fields(implode(',', $fields))
                ->values(array($data))->result();
        echo json_encode(array(
            'errorMsg' => false
        ));
    }

    public function delAction() {
        $table = @$_REQUEST['table'];
		if(@$this->statusDeletes[$table]) {
			if (isset($_REQUEST['id'])) {
				_db()->update($table)->set(array('status' => 'deleted'))->where('id=' . $_REQUEST['id'])->result();
				$deletions = @$this->deletes[$table];
				if($deletions) {
					foreach($deletions as $delTable => $refField) {
						_db()->update($delTable)->set(array('status' => 'deleted'))->where( $refField . '=' . $_REQUEST['id'])->result();
					}
				}
			} else if (isset($_REQUEST['ids'])) {
				_db()->update($table)->set(array('status' => 'deleted'))->where('id in (' . implode(', ', $_REQUEST['ids']) . ')')->result();
				$deletions = @$this->deletes[$table];
				if($deletions) {
					foreach($deletions as $delTable => $refField) {
						_db()->update($delTable)->set(array('status' => 'deleted'))->where($refField . ' in (' . implode(', ', $_REQUEST['ids']) . ')')->result();
					}
				}
			}	
			echo json_encode(array(
				'errorMsg' => false,
				'success' => true
			));
			return ;
		}
		
        if (isset($_REQUEST['id'])) {
            _db()->delete()->from($table)->where('id=' . $_REQUEST['id'])->result();
			$deletions = @$this->deletes[$table];
			if($deletions) {
				foreach($deletions as $delTable => $refField) {
					_db()->delete()->from($delTable)->where( $refField . '=' . $_REQUEST['id'])->result();
				}
			}
        } else if (isset($_REQUEST['ids'])) {
            _db()->delete()->from($table)->where('id in (' . implode(', ', $_REQUEST['ids']) . ')')->result();
			$deletions = @$this->deletes[$table];
			if($deletions) {
				foreach($deletions as $delTable => $refField) {
					_db()->delete()->from($delTable)->where($refField . ' in (' . implode(', ', $_REQUEST['ids']) . ')')->result();
				}
			}
		}

        echo json_encode(array(
            'errorMsg' => false,
            'success' => true
        ));
    }

    public function checkConstraints($table, $data) {
        $constraints = @$this->constraints[$table];
        if ($constraints) {
            foreach ($constraints as $constraint) {
                if (@$constraint['type'] == 'key') {
                    $key = $constraint['key'];
                    $conds = array();
                    foreach ($key as $field) {
                        $conds[] = $field . '=\'' . @mysql_escape_string($data[$field]) . '\'';
                    }
                    $items = _db()->select('*')->from($table)->where(implode(' AND ', $conds))->result();
                    if (count($items)) {
                        $constraint['row'] = $items[0];
                        return $constraint;
                    }
                }
            }
        }
        return false;
    }

    public function replaceAction() {
        $table = @$_REQUEST['table'];
        $fields = @$this->inserts[$table] ? @$this->inserts[$table] : array();
        $data = array();
        foreach ($fields as $field) {
            if (isset($_REQUEST[$field])) {
                $data[$field] = $_REQUEST[$field];
            }
        }
        if ($result = $this->checkConstraints($table, $data)) {
            _db()->update($table)
                    ->set($data)->where('id=' . $result['row']['id'])->result();
        } else {
            _db()->insert($table)
                    ->fields(implode(',', $fields))
                    ->values(array($data))->result();
        }
        echo json_encode(array(
            'errorMsg' => false,
            'success' => true
        ));
    }
	
	public function updateAction() {
        $table = @$_REQUEST['table'];
        $fields = @$this->inserts[$table] ? @$this->inserts[$table] : array();
        $data = array();
        foreach ($fields as $field) {
            if (isset($_REQUEST[$field])) {
                $data[$field] = $_REQUEST[$field];
            }
        }
		if(@$_REQUEST['id'] && @$_REQUEST['noConstraint']) {
			_db()->update($table)
						->set($data)->where('id=' . $_REQUEST['id'])->result();
		} else {
			if ($result = $this->checkConstraints($table, $data)) {
				_db()->update($table)
						->set($data)->where('id=' . $result['row']['id'])->result();
			}
		}
        echo json_encode(array(
            'errorMsg' => false,
            'success' => true
        ));
    }

}
