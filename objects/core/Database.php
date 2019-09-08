<?php
class PzkCoreDatabase extends PzkObjectLightWeight {

    public $connId;
    public $options;

    /**
     * Hàm khởi tạo và clear
     * @param string $attrs các thuộc tính
     */
    public function __construct($attrs = array()) {
        parent::__construct($attrs);
        $this->clear();
    }
	
    /**
     * Join với table với điều kiện join, và kiểu join
     * @param string $table bảng cần join
     * @param mixed $conds điều kiện join
     * @param string $type kiểu join: inner, left, right, mặc định là inner
     * @return PzkCoreDatabase
     */
	public function join($table, $conds, $type = 'inner') {
		if(!isset($this->options['joins'])) {
			$this->options['joins'] = array();
		}
		$this->options['joins'][$table] = array('conds' => $this->buildCondition($conds), 'type' => $type);
		return $this;
	}
	
	public function leftJoin($table, $conds) {
		return $this->join($table, $conds, 'left');
	}
	
	public function rightJoin($table, $conds) {
		return $this->join($table, $conds, 'right');
	}

	/**
	 * Kết nối tới cơ sở dữ liệu
	 */
    public function connect() {
        if (!@$this->connId) {
            $this->connId = @mysqli_connect(@$this->host, @$this->user, @$this->password, @$this->dbName) or die("Cant connect {$this->host} with username '{$this->user}' and password '{$this->password}' with db '{$this->dbName}'");

			//mysqli_query("SET character_set_results=utf8", $this->connId);
            //mysqli_select_db(@$this->dbName, $this->connId) or die('Cant select db: ' . @$this->dbName);
            if(pzk_app()->name=='qlhs') {
				mysqli_query($this->connId, 'set names utf-8');
			} else {
				mysqli_set_charset($this->connId, 'utf8');
			}
        }
    }

    /**
     * Chèn vào bảng
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function insert($table) {
        $this->options['action'] = 'insert';
        $this->options['table'] = "`$table`";
        return $this;
    }

    /**
     * Giá trị cần chèn vào bảng
     * @param array $values: dạng array($row1, $row2), trong đó $row1 là giá trị bản ghi
     * @return PzkCoreDatabase
     */
    public function values($values) {
        $this->options['values'] = $values;
        return $this;
    }

    /**
     * Các trường cần insert vào
     * @param string $fields dạng chuỗi, cách nhau bởi dấu ,
     * @return PzkCoreDatabase
     */
    public function fields($fields) {
        $this->options['fields'] = $fields;
        return $this;
    }

    /**
     * Lệnh xóa
     * @return PzkCoreDatabase
     */
    public function delete() {
        $this->options['action'] = 'delete';
        return $this;
    }

    /**
     * Lệnh cập nhật
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function update($table) {
        $this->options['action'] = 'update';
        $this->options['table'] = $table;
        return $this;
    }

    /**
     * Lệnh đặt giá trị cho cập nhật
     * @param string $values: giá trị dạng array('trường' => 'giá trị')
     * @return PzkCoreDatabase
     */
    public function set($values) {
        $this->options['values'] = $values;
        return $this;
    }

    /**
     * Lệnh SELECT
     * @param string $fields các trường, cách nhau bởi dấu phẩy ,
     * @return PzkCoreDatabase
     */
    public function select($fields) {
        $this->options['action'] = 'select';
        $this->options['fields'] = $fields;
        return $this;
    }
    
    /**
     * Add more fields to select
     * @param string $fields
     * @return PzkCoreDatabase
     */
    public function addFields($fields) {
    	if(!@$this->options['fields'])
    		$this->select($fields);
    	else 
    		$this->options['fields'] .= ',' . $fields;
    	return $this;
    }

    /**
     * Lệnh đếm
     * @return PzkCoreDatabase
     */
    public function count() {
        $this->options['action'] = 'count';
        return $this;
    }

    /**
     * Lệnh FROM
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function from($table) {
        if (strpos($table, '`') !== false || preg_match('/^[\w\d_]/', $table) !== false) {
            $this->options['table'] = $table;
        } else {
            $this->options['table'] = '`' . $table . '`';
        }
        return $this;
    }

    /**
     * Lệnh WHERE
     * @param mixed $conds điều kiện: là chuỗi hoặc là biểu thức dạng mảng
     * @return PzkCoreDatabase
     */
    public function where($conds) {
        $condsStr = $this->buildCondition($conds);
        if($condsStr == '1') {
            return $this;
        }
        if(isset($this->options['conds'])) {
            $this->options['conds'] = pzk_or(@$this->options['conds'], 1) . ' AND ' . $condsStr;
        } else {
            $this->options['conds'] = $condsStr;
        }
        
        return $this;
    }
	
	public function equal($col, $val) {
		return $this->where(array($col, $val));
	}
    
    /**
     * Sử dụng condition builder
     * @see PzkCoreDatabaseArrayCondition
     * @return PzkCoreDatabase
     */
	public function useCB() {
		$this->options['useConditionBuilder'] = true;
		return $this;
	}
	/**
	 * Sử dụng cache
	 * @param string $timeout
	 * @return PzkCoreDatabase
	 */
	public function useCache($timeout = null) {
		$this->options['useCache'] = true;
		$this->options['cacheTimeout'] = $timeout;
		return $this;
	}
	/**
	 * Lệnh xây dựng điều kiện từ biểu thức dạng mảng
	 * @see PzkCoreDatabaseArrayCondition
	 * @param mixed $conds điều kiện
	 * @return string điều kiện sql
	 */
	public function buildCondition($conds) {
		$builder = pzk_element('conditionBuilder');
		if($builder) {
			return $builder->build($conds);
		}
	}
	
	
	/**
	 * Lọc dữ liệu theo mảng, dùng như where
	 * @param array $filters bộ lọc
	 * @return PzkCoreDatabase
	 */
    public function filters($filters) {
        if ($filters && is_array($filters)) {
            $this->where($filters);
        }
        return $this;
    }

    /**
     * Sắp xếp thứ tự
     * @param string $orderBy
     * @return PzkCoreDatabase
     */
    public function orderBy($orderBy) {
        $this->options['orderBy'] = $orderBy;
        return $this;
    }

    /**
     * Gom nhóm
     * @param string $groupBy
     * @return PzkCoreDatabase
     */
    public function groupBy($groupBy) {
		if(!$groupBy) return $this;
        $this->options['groupBy'] = $groupBy;
        return $this;
    }

    /**
     * Điều kiện having
     * @param mixed $conds
     * @return PzkCoreDatabase
     */
    public function having($conds) {
		if(!$conds) return $this;
        if (isset($this->options['groupBy'])) {
			$condsStr = $this->buildCondition($conds);
            $this->options['having'] =  pzk_or(@$this->options['having'], 1) . ' AND ' . $condsStr;;
        }
		return $this;
    }

    /**
     * Thực thi query
     * @param string $entity trả về mảng dạng entity hay dạng mảng thông thường
     * @return array
     */
    public function result($entity = false) {
        $this->connect();
        //mysqli_query('set names utf-8', $this->connId);
        $rslt = array();
        if (@$this->options['action'] == 'select') {
            $query = 'select ' . $this->options['fields']
                    . ' from ' . $this->options['table'];
			if(isset($this->options['joins'])) {
				$joins = $this->options['joins'];
				foreach($joins as $table => $join) {
					$query.= ' ' . $join['type'] . ' join ' . $table . ' on ' . $join['conds'];
				}
			}
            $query .= ((@$this->options['conds']) ? ' where ' . $this->options['conds'] : '')
                    . (@$this->options['groupBy'] ? ' group by ' . $this->options['groupBy'] : '')
                    . (@$this->options['having'] ? ' having ' . $this->options['having'] : '')
                    . (@$this->options['orderBy'] ? ' order by ' . $this->options['orderBy'] : '')
                    . (@$this->options['pagination'] ?
                            ' limit ' . $this->options['start'] . ', '
                            . $this->options['pagination'] : '');
			if(@$this->options['useCache']) {
				$data = pzk_filevar(md5($query . $entity) , null, isset($this->options['cacheTimeout'])? $this->options['cacheTimeout']: null);
				if($data !== NULL) {
					return $data;
				}
			}
            $result = mysqli_query($this->connId, $query);
            if (mysqli_errno($this->connId)) {
                $message = 'Invalid query: ' . mysqli_error($this->connId) . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
            while ($row = mysqli_fetch_assoc($result)) {
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
			if(@$this->options['useCache']) {
				pzk_filevar(md5($query . $entity), $rslt);
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
                    $colVals[] = "'" . @mysql_escape_string(@$value[$col]) . "'";
                }
                $vals[] = '(' . implode(',', $colVals) . ')';
            }
            $table = $this->options['table'];
            $fields = $this->options['fields'];
            $values = implode(',', $vals);
            $query = "insert into $table($fields) values $values";
            $result = mysqli_query($this->connId, $query);
            if (mysqli_errno($this->connId)) {
                $message = 'Invalid query: ' . mysqli_error($this->connId) . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
            if ($result) {
				$insertId = mysqli_insert_id($this->connId);
                return $insertId;
            }
            return 0;
        } else if (@$this->options['action'] == 'update') {
            $columns = $this->describle($this->options['table']);
            $vals = array();
            foreach ($this->options['values'] as $key => $value) {
                if (in_array($key, $columns)) {
                    $vals[] = '`'.$key . '`=\'' . @mysql_escape_string($value) . '\'';
                }
            }
            $values = implode(',', $vals);
            $query = "update {$this->options['table']} set $values where {$this->options['conds']}";
            $result = mysqli_query($this->connId, $query);
            if (mysqli_errno($this->connId)) {
                $message = 'Invalid query: ' . mysqli_error($this->connId) . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
			return $result;
        } else if (@$this->options['action'] == 'delete') {
            $query = "delete from {$this->options['table']} where {$this->options['conds']}";
            $result = mysqli_query($this->connId, $query);
            if (mysqli_errno($this->connId)) {
                $message = 'Invalid query: ' . mysqli_error($this->connId) . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
			return $result;
        }
        return $this;
    }
	
    /**
     * Trả về câu query trước khi execute
     * @return string
     */
	public function getQuery() {
		if (@$this->options['action'] == 'select') {
            $query = 'select ' . $this->options['fields']
                    . ' from ' . $this->options['table'];
			if(isset($this->options['joins'])) {
				$joins = $this->options['joins'];
				foreach($joins as $table => $join) {
					$query.= ' ' . $join['type'] . ' join ' . $table . ' on ' . $join['conds'];
				}
			}
            $query .= ((@$this->options['conds']) ? ' where ' . $this->options['conds'] : '')
                    . (@$this->options['groupBy'] ? ' group by ' . $this->options['groupBy'] : '')
                    . (@$this->options['having'] ? ' having ' . $this->options['having'] : '')
                    . (@$this->options['orderBy'] ? ' order by ' . $this->options['orderBy'] : '')
                    . (@$this->options['pagination'] ?
                            ' limit ' . $this->options['start'] . ', '
                            . $this->options['pagination'] : '');
			return $query;
        }
	}
	
	/**
	 * Trả về một bản ghi
	 * @param string $entity: trả về theo entity hay theo dạng mảng thông thường
	 * @return PzkEntityModel
	 */
	public function result_one($entity = false) {
		$this->limit(1,0);
		$rows = $this->result($entity);
		if(count($rows)) {
			return $rows[0];
		}
		return NULL;
	}
	
	/**
	 * Phân trang
	 * @param int $pagination: số bản ghi / trang
	 * @param int $page: số hiệu trang
	 * @return PzkCoreDatabase
	 */
    public function limit($pagination, $page = 0) {
        $this->options['start'] = $pagination * $page;
        $this->options['pagination'] = $pagination;
        return $this;
    }
	
    /**
     * Clear query để bắt đầu lại
     * @return PzkCoreDatabase
     */
    public function clear() {
        $this->options = array();
		//$this->useCache(15*60);
        return $this;
    }

    /**
     * Describle một bảng: trả về các columns của bảng
     * @param string $table
     * @param boolean $columns trả về danh sách tên column hay trả về danh sách chi tiết của column
     * @return array
     */
    public function describle($table, $columns = true) {
        $result = mysqli_query($this->connId, 'describe ' . $table);
        $rslt = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($columns) {
                $rslt[] = $row['Field'];
            } else {
                $rslt[] = $row;
            }
        }
        return $rslt;
    }

    /**
     * Query một câu lệnh sql thông thường
     * @param string $sql câu lệnh sql
     * @return array:
     */
    public function query($sql) {
        $this->connect();
        if (@$_REQUEST['showQuery'])
            pre($sql);
        $result = mysqli_query($this->connId, $sql);
        if (mysqli_errno($this->connId)) {
                $message = 'Invalid query: ' . mysqli_error($this->connId) . "\n";
                $message .= 'Whole query: ' . $sql;
                die($message);
            }
        if (is_bool($result))
            return $result;
        $rslt = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rslt[] = $row;
        }
        return $rslt;
    }
	
    /**
     * Query lấy một bản ghi
     * @param string $sql câu lệnh sql
     * @return array
     */
	public function query_one($sql) {
		$result = $this->query($sql);
		if(is_bool($result)) return $result;
		return $result[0];
	}
	
	/**
	 * Lấy các trường của một bảng trong csdl
	 * @param string $table
	 * @return array mảng các trường
	 */
	public function getFields($table) {
		$query = "select COLUMN_NAME from information_schema.columns where table_name = '$table' order by ordinal_position";
		$fields = $this->query($query);
		$columns = array();
		foreach($fields as $field) {
			$columns[] = $field['COLUMN_NAME'];
		}
		return $columns;
	}
	
	/**
	 * Xây dựng insert data
	 * @param string $table bảng
	 * @param array $data mảng dữ liệu chưa được lọc
	 * @return array mảng dữ liệu insert được
	 */
	public function buildInsertData($table, $data) {
        $fields = $this->getFields($table);
        $fieldTypes = $this->describle($table, false);
        $fieldTypesMap = array();
        foreach($fieldTypes as $fieldType) {
            $fieldTypesMap[$fieldType['Field']] = $fieldType;
        }
		$params = array();
		$result = array();
		foreach($data as $key => $val) {
			if(in_array($key, $fields)) {
				if(is_array($val)) {
					$val = ','.implode(',', $val).',';
                }
                if(isset($fieldTypesMap[$key]) && strpos($fieldTypesMap[$key]['Type'], 'int(') !== false ) {
                    if(!$val) {
                        $result[$key] = '0';
                    } else {
                        $result[$key] = intval($val);
                    }
                    
                } elseif(isset($fieldTypesMap[$key]) && ( strpos($fieldTypesMap[$key]['Type'], 'float') !== false 
                    || strpos($fieldTypesMap[$key]['Type'], 'double') !== false ) ) {
                        if(!$val) {
                            $result[$key] = '0';
                        } else {
                            $result[$key] = floatval($val);
                        }
                } elseif(isset($fieldTypesMap[$key]) && $fieldTypesMap[$key]['Type'] === 'date' ) {
                    if(!$val) {
                        $val = '0000-00-00';
                    }
                    $result[$key] = $val;
                } elseif(isset($fieldTypesMap[$key]) && $fieldTypesMap[$key]['Type'] === 'datetime' ) {
                    if(!$val) {
                        $val = '0000-00-00 00:00:00';
                    }
                    $result[$key] = $val;
                } else {
                    $result[$key] = $val;
                }
			} else {
                $params[$key] = $val;
			}
		}
		if(in_array('params', $fields)) {
			$result['params'] = json_encode($params);
		}
		return $result;
	}
	
	/**
	 * Trả về một entity trong model/entity
	 * @param string $entity tên entity theo kiểu edu.student
	 * @return PzkEntityModel
	 */
	public function getEntity($entity) {
		return pzk_loader()->createModel('entity.' . $entity);
	}
	/**
	 * Trả về entity table
	 * @param string $table tên bảng cơ sở dữ liệu
	 * @return PzkEntityTableModel
	 */
	public function getTableEntity($table) {
		$entity = $this->getEntity('table')->setTable($table);
		return $entity;
	}
	
	/**
	 * Gọi hàm ảo
	 * @param string $name
	 * @param array $arguments
	 * @throws \Exception
	 * @return PzkCoreDatabase
	 */
	public function __call($name, $arguments) {

		//Getting and setting with $this->property($optional);

		if (property_exists(get_class($this), $name)) {


			//Always set the value if a parameter is passed
			if (count($arguments) == 1) {
				/* set */
				$this->$name = $arguments[0];
			} else if (count($arguments) > 1) {
				throw new \Exception("Setter for $name only accepts one parameter.");
			}

			//Always return the value (Even on the set)
			return $this->$name;
		}

		//If it doesn't chech if its a normal old type setter ot getter
		//Getting and setting with $this->getProperty($optional);
		//Getting and setting with $this->setProperty($optional);
		$prefix6 = substr($name, 0, 6);
		$property6 = strtolower($name[6]) . substr($name, 7);
		$prefix5 = substr($name, 0, 5);
		$property5 = strtolower($name[5]) . substr($name, 6);
		$prefix4 = substr($name, 0, 4);
		$property4 = strtolower($name[4]) . substr($name, 5);
		$prefix3 = substr($name, 0, 3);
		$property3 = strtolower($name[3]) . substr($name, 4);
		$prefix2 = substr($name, 0, 2);
		$property2 = strtolower($name[2]) . substr($name, 3);
		switch ($prefix6) {
			case 'select':
			if($property6 == 'all') {
				return $this->select('*');
			}
			if($property6 == 'none') {
				return $this->select('');
			}
			return $this->addFields(str_replace('__', '.', $property6));
			break;
		}
		switch ($prefix5) {
			case 'where':
				return $this->where(array($property5, $arguments[0]));
				break;
			case 'equal':
				return $this->where(array('equal', $property5, $arguments[0]));
				break;
			case 'nlike':
				return $this->where(array('notlike', $property5, $arguments[0]));
				break;
			case 'notin':
				return $this->where(array('notin', $property5, $arguments[0]));
				break;
			case 'isnull':
				return $this->where(array('isnull', $property5, $arguments[0]));
				break;
			case 'nnull':
				return $this->where(array('isnotnull', $property5, $arguments[0]));
				break;
			case 'ljoin':
				return $this->leftJoin($property5, $arguments[0]);
				break;
			case 'rjoin':
				return $this->rightJoin($property5, $arguments[0]);
				break;
		}
		switch ($prefix4) {
			case 'like':
				return $this->where(array('like', $property4, $arguments[0]));
				break;
			case 'from':
				return $this->from($property4);
				break;
			case 'join':
				return $this->join($property4, $arguments[0], @$arguments[1]);
				break;
		}
		switch ($prefix3) {
			case 'gte':
				return $this->where(array('gte', $property3, $arguments[0]));
				break;
			case 'lte':
				return $this->where(array('lte', $property3, $arguments[0]));
				break;
		}
		switch ($prefix2) {
			case 'gt':
				return $this->where(array('gt', $property2, $arguments[0]));
				break;
			case 'lt':
				return $this->where(array('lt', $property2, $arguments[0]));
				break;
			case 'in':
				return $this->where(array('in', $property2, $arguments[0]));
				break;
		}
		return parent::__call($name, $arguments);
	}

}

/**
 * Lấy ra database instance
 * @return PzkCoreDatabase
 */
function _db() {
    $db = pzk_store_element('db')->clear();
	$db->select('*');
	$db->useCB();
	return $db;
}

/**
 * Thực thi câu lệnh sql
 * @param string $sql
 * @return array
 */
function db_query($sql) {
    return _db()->query($sql);
}

function eand($arr) {
    array_unshift($arr, 'and');
    return $arr;
}

function eor($arr) {
    array_unshift($arr, 'or');
    return $arr;
}

function mand() {
    $arr = func_get_args();
    return eand($arr);
}

function mor() {
    $arr = func_get_args();
    return eor($arr);
}

function meq($a, $b) {
    return array($a, $b);
}