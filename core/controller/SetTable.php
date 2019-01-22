<?php 
class PzkSetTableController extends PzkController {
	public $tables = array();
    public $inserts = array();
    public $constraints = array();
    public $filters = array();
	public function __construct() {
		$table = @$_REQUEST['table'];
		if(!$table) {
			$request = pzk_element('request');
			$table = $request->getSegment(3);
			$_REQUEST['table'] = $table;
		}
		$this->set = _db()->useCB()->select('*')->from('attribute_set')->where(array('code', $table))->result_one('attribute.set');
		$this->attributes = $this->set->getAttributes();
		$this->inserts[$table] = array();
		$this->filters[$table] = array(); 
		if($queryId = $this->set->get('queryId')) {
			$this->query = _db()->getEntity('query.query')->load($queryId);
			$this->tables[$table] = array(
				'table' => $this->query->getTableSQL(),
				'fields' => $this->query->getFieldsSQL()
			);
		}
		foreach($this->attributes as $attribute) {
			$this->inserts[$table][] = $attribute->get('code');
			if($attribute->get('filterable')) {
				$this->filters[$table][$attribute->get('code')] = array('like' => (isset($this->query) && $this->query->get('code')?$this->query->get('code') . '`.`':'') . $attribute->get('code'));
			}
		}
		
	}
	
    public function jsonAction() {
        $table = @$_REQUEST['table'];
		$oldTable = $table;
        $fields = @$this->tables[$table] ? @$this->tables[$table] : '*';
        $filters = @$this->filters[$table];
        $groupBy = false;
		$arrFields = array();
		if (is_array($fields)) {
			$arrFields = $fields;
            $table = $fields['table'];
            $groupBy = isset($fields['groupBy']) ? $fields['groupBy'] : false;
			$fields = $fields['fields'];
        }
        $conds = array();
		$havingConds = array();
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
        }
        $rows = @$_REQUEST['rows'] ? @$_REQUEST['rows'] : 10;
        $page = @$_REQUEST['page'] ? @$_REQUEST['page'] : 1;
        $total = _db()->select('count(*) as val')->from($oldTable);
		
		/*
		if($groupBy) {
			$total = $total->groupBy($groupBy);
		}*/
		$total = $total->result();
        $orderBy = array();
        $sort = explode(',', @$_REQUEST['sort']);
        $order = explode(',', @$_REQUEST['order']);
        foreach ($sort as $index => $val) {
            $orderBy[] = $sort[$index] . ' ' . $order[$index];
        }
        $orderBy = implode(',', $orderBy);
        if (!trim($orderBy)) {
            $orderBy = false;
        }
        $items = _db()
                        ->select($fields)
                        ->from($table)
                        ->where($conds)
                        ->orderBy($orderBy)
                        ->limit($rows, ($page - 1));
		if($groupBy) {
			$items = $items->groupBy($groupBy);
		}
		if(count($havingConds)) {
			$items->having($havingConds);
		}
		$items = $items->result();
        $data = array(
            'total' => $total[0]['val'],
            'rows' => $items,
			'groupBy' => $groupBy,
			'fields' => $arrFields
        );
        echo json_encode($data);
    }
	
	public function treejsonAction() {
		//$_REQUEST['showSQL'] = 1;
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$table = @$_REQUEST['table'];
		$oldTable = $table;
        $fields = @$this->tables[$table] ? @$this->tables[$table] : '*';
        $filters = @$this->filters[$table];
        if (is_array($fields)) {
            $table = $fields['table'];
            $fields = $fields['fields'];
        }
        $conds = array();
		$conds[] = (isset($this->query)? $this->query->get('code') . '.':'') . "parentId=$id";
        $rows = @$_REQUEST['rows'] ? @$_REQUEST['rows'] : 1000;
        $page = @$_REQUEST['page'] ? @$_REQUEST['page'] : 1;
        $total = _db()->select('count(*) as val')->from($oldTable)->result();
        $orderBy = array();
        $sort = explode(',', @$_REQUEST['sort']);
        $order = explode(',', @$_REQUEST['order']);
        foreach ($sort as $index => $val) {
            $orderBy[] = $sort[$index] . ' ' . $order[$index];
        }
        $orderBy = implode(',', $orderBy);
        if (!trim($orderBy)) {
            $orderBy = (isset($this->query)? $this->query->get('code') . '.':'') . 'id desc';
        }
        $items = _db()
                        ->select($fields)
                        ->from($table)
                        ->where($conds)
                        ->orderBy($orderBy)
                        ->limit($rows, ($page - 1))->result();
		foreach($items as &$item) {
			if($this->_hasChild($oldTable, $item['id'])) {
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
			if(strpos($field, '[]') !== false) {
				$field = str_replace('[]', '', $field);
			}
            if (isset($_REQUEST[$field])) {
                $data[$field] = $_REQUEST[$field];
            }
        }
		$entity = null;
		if(isset($this->set)) $entity = _db()->getEntity($this->set->get('entity'));
		if($entity !== null) {
			$entity->setData($data);
			$entity->set('id', $_REQUEST['id']);
			$entity->save();
		} else {
			$row = _db()->buildInsertData($table, $data);
			_db()->update($table)
                ->set($row)->where('id=' . $_REQUEST['id'])->result();
		}
        echo json_encode(array(
            'errorMsg' => false
        ));
    }

    public function addAction() {
        $table = @$_REQUEST['table'];
        $fields = @$this->inserts[$table] ? @$this->inserts[$table] : array();
        $data = array();
        foreach ($fields as $field) {
			if(strpos($field, '[]') !== false) {
				$field = str_replace('[]', '', $field);
			}
            if (isset($_REQUEST[$field])) {
                $data[$field] = $_REQUEST[$field];
            }
        }
        if ($result = $this->checkConstraints($table, $data)) {
            echo json_encode(array(
                'errorMsg' => $result['message']
            ));
            return false;
        }
		$entity = null;
		if(isset($this->set)) $entity = _db()->getEntity($this->set->get('entity'));
		if($entity !== null) {
			$entity->setData($data);
			$entity->save();
		} else {
			$row = _db()->buildInsertData($table, $data);
			_db()->insert($table)
                ->fields(implode(',', array_keys($row)))
                ->values(array($row))->result();
		}
        echo json_encode(array(
            'errorMsg' => false
        ));
    }

    public function delAction() {
        $table = @$_REQUEST['table'];
        if (isset($_REQUEST['id'])) {
			if(isset($this->set)) $entity = _db()->getEntity($this->set->get('entity'));
			if($entity !== null) {
				$entity->load($_REQUEST['id']);
				$entity->children('delete');
			} else {
			
				_db()->delete()->from($table)->where('id=' . $_REQUEST['id'])->result();
				$deletions = @$this->deletes[$table];
				if($deletions) {
					foreach($deletions as $delTable => $refField) {
						_db()->delete()->from($delTable)->where( $refField . '=' . $_REQUEST['id'])->result();
					}
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
}