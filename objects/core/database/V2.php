<?php
class PzkCoreDatabaseV2 extends PzkObjectLightWeight {

    public $connId;
    public $options;

    public function __construct($attrs = array()) {
        parent::__construct($attrs);
        $this->clear();
    }

    public function connect() {
        if (!@$this->connId) {
            $this->connId = @mysql_connect(@$this->host, @$this->user, @$this->password) or die('Cant connect');
			//mysql_query("SET character_set_results=utf8", $this->connId);
            mysql_select_db(@$this->dbName, $this->connId) or die('Cant select db: ' . @$this->dbName);
            mysql_query('set names utf-8', $this->connId);
        }
    }

    public function insert($table) {
        $this->options['action'] = 'insert';
        $this->options['table'] = "`$table`";
        return $this;
    }

    public function values($values) {
        $this->options['values'] = $values;
        return $this;
    }

    public function fields($fields) {
        $this->options['fields'] = $fields;
        return $this;
    }

    public function delete() {
        $this->options['action'] = 'delete';
        return $this;
    }

    public function update($table) {
        $this->options['action'] = 'update';
        $this->options['table'] = $table;
        return $this;
    }

    public function set($values) {
        $this->options['values'] = $values;
        return $this;
    }

    public function select($fields) {
        $this->options['action'] = 'select';
        $this->options['fields'] = $fields;
        return $this;
    }

    public function count() {
        $this->options['action'] = 'count';
        return $this;
    }

    public function from($table) {
        if (strpos($table, '`') !== false) {
            $this->options['table'] = $table;
        } else {
            $this->options['table'] = '`' . $table . '`';
        }
        return $this;
    }

    public function where($conds) {
		$condsStr = $this->buildCondition($conds);
        $this->options['conds'] = pzk_or(@$this->options['conds'], 1) . ' AND ' . $condsStr;
        return $this;
    }
	
	public function buildCondition($conds) {
		if(is_string($conds)) return $conds;
	}

    public function filters($filters) {
        if ($filters && is_array($filters)) {
            $this->where($filters);
        }
        return $this;
    }

    public function orderBy($orderBy) {
        $this->options['orderBy'] = $orderBy;
        return $this;
    }

    public function groupBy($groupBy) {
        $this->options['groupBy'] = $groupBy;
        return $this;
    }

    public function having($conds) {
        if (isset($this->options['groupBy'])) {
			$condsStr = $this->buildCondition($conds);
            $this->options['having'] =  pzk_or(@$this->options['having'], 1) . ' AND ' . $condsStr;;
        }
		return $this;
    }

    public function result($entity = false) {
        $this->connect();
        mysql_query('set names utf-8', $this->connId);
        $rslt = array();
        if (@$this->options['action'] == 'select') {
            $query = 'select ' . $this->options['fields']
                    . ' from ' . $this->options['table']
                    . ((@$this->options['conds']) ? ' where ' . $this->options['conds'] : '')
                    . (@$this->options['groupBy'] ? ' group by ' . $this->options['groupBy'] : '')
                    . (@$this->options['having'] ? ' having ' . $this->options['having'] : '')
                    . (@$this->options['orderBy'] ? ' order by ' . $this->options['orderBy'] : '')
                    . (@$this->options['pagination'] ?
                            ' limit ' . $this->options['start'] . ', '
                            . $this->options['pagination'] : '');
            if (@$_REQUEST['showSQL'])
                echo $query . '<br />';
            $result = mysql_query($query, $this->connId);
            if (mysql_errno()) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
            while ($row = mysql_fetch_assoc($result)) {
				if(@$row['params']) {
					$params = json_decode($row['params'], true);
					$row = array_merge($row, $params);
				}
				if($entity) {
					$entityObj = pzk_loader()->createModel('entity.' . $entity);
					$entityObj->setData($row);
					$rslt[] = $entityObj;
				} else {
					$rslt[] = $row;
				}
            }
            return $rslt;
        } else if (@$this->options['action'] == 'insert') {
			if(!@$this->options['fields']) {
				$this->options['fields'] = implode(',', $this->getFields($this->options['table']));
			}
            $vals = array();
            $columns = explode(',', $this->options['fields']);
            foreach ($this->options['values'] as $value) {

                $colVals = array();
                foreach ($columns as $col) {
					$col = trim($col);
                    $col = str_replace('`', '', $col);
                    $colVals[] = "'" . @mysql_real_escape_string(@$value[$col]) . "'";
                }
                $vals[] = '(' . implode(',', $colVals) . ')';
            }
            $table = $this->options['table'];
            $fields = $this->options['fields'];
            $values = implode(',', $vals);
            $query = "insert into $table($fields) values $values";
            if (@$_REQUEST['showQuery'])
                echo $query . '<br />';
            $result = mysql_query($query, $this->connId);
            if ($errors = mysql_error()) {
                echo $query;
                pre($errors);
            }
            if ($result) {
                return mysql_insert_id();
            }
            return 0;
        } else if (@$this->options['action'] == 'update') {
            $columns = $this->describle($this->options['table']);
            $vals = array();
            foreach ($this->options['values'] as $key => $value) {
                if (in_array($key, $columns)) {
                    $vals[] = $key . '=\'' . @mysql_real_escape_string($value) . '\'';
                }
            }
            $values = implode(',', $vals);
            $query = "update {$this->options['table']} set $values where {$this->options['conds']}";
            if (@$_REQUEST['showQuery'])
                echo($query . '<br />');
            return mysql_query($query, $this->connId);
        } else if (@$this->options['action'] == 'delete') {
            $query = "delete from {$this->options['table']} where {$this->options['conds']}";
            return mysql_query($query, $this->connId);
        }
        return $this;
    }
	
	public function result_one($entity = false) {
		$this->limit(1,0);
		$rows = $this->result($entity);
		if(count($rows)) {
			return $rows[0];
		}
		return NULL;
	}
	
	public function treeDelete($table, $id) {
		$children = _db()->select('id')->from($table)->where('parentId=' . $id)->result();
		foreach($children as $row) {
			$this->treeDelete($table, $row['id']);
		}
		_db()->delete()->from($table)->where('id=' . $id)->result();
	}
	
	public function getParent($table, $id, $conditions = false) {
		$item = _db()->select('*')->from($table)->where('id=' . $id)->result_one();
		if(!$item) return NULL;
		$itemWithCondition = _db()->select('*')->from($table)->where('id=' . $id . ' and ' . pzk_or($conditions, '1'))->result_one();
		if($itemWithCondition) return $itemWithCondition;
		if(!$item['parentId']) return NULL;
		return $this->getParent($table, $item['parentId'], $conditions);
	}
	
	public function getChildren($table, $parentId, $conditions = false) {
		return _db()->select('*')->from($table)->where('parentId=' . $parentId . ' and ' . pzk_or($conditions, '1'))->result();
	}

    public function limit($pagination, $page) {
        $this->options['start'] = $pagination * $page;
        $this->options['pagination'] = $pagination;
        return $this;
    }

    public function clear() {
        $this->options = array();
        return $this;
    }

    public function describle($table, $columns = true) {
        $result = mysql_query('describe ' . $table, $this->connId);
        $rslt = array();
        while ($row = mysql_fetch_assoc($result)) {
            if ($columns) {
                $rslt[] = $row['Field'];
            } else {
                $rslt[] = $row;
            }
        }
        return $rslt;
    }

    public function query($sql) {
        $this->connect();
        if (@$_REQUEST['showQuery'])
            pre($sql);
        $result = mysql_query($sql, $this->connId);
        if (is_bool($result))
            return $result;
        $rslt = array();
        while ($row = mysql_fetch_assoc($result)) {
            $rslt[] = $row;
        }
        return $rslt;
    }
	
	public function query_one($sql) {
		$result = $this->query($sql);
		if(is_bool($result)) return $result;
		return $result[0];
	}
	
	public function getFields($table) {
		$query = "select COLUMN_NAME from information_schema.columns where table_name = '$table' order by ordinal_position";
		$fields = $this->query($query);
		$columns = array();
		foreach($fields as $field) {
			$columns[] = $field['COLUMN_NAME'];
		}
		return $columns;
	}
	
	public function buildInsertData($table, $data) {
		$fields = $this->getFields($table);
		$params = array();
		$result = array();
		foreach($data as $key => $val) {
			if(in_array($key, $fields)) {
				$result[$key] = $val;
			} else {
				$params[$key] = $val;
			}
		}
		if(in_array('params', $fields)) {
			$result['params'] = json_encode($params);
		}
		return $result;
	}

    public function get($sql, $field = false) {
        $items = $this->query($sql);
        if ($items) {
            if ($field) {
                return $items[0][$field];
            }
            return $items[0];
        }
        return NULL;
    }
	
	public function getRow($table, $id) {
		return _db()->select('*')->from($table)->where('id=' . $id)->result_one();
	}
	
	public function getEntity($entity) {
		return pzk_loader()->createModel('entity.' . $entity);
	}

}