<?php
class PzkCoreDatabaseArrayCondition extends PzkObject {
	public static $operations = array('column', 'string', 'equal', 'and', 'or', 
		'like', 'notlike', 'in', 'notin',
		'isnull', 'isnotnull', 'gte', 'lte', 'gt', 'lt', 'sql');
	public function build($cond) {

		// nếu $cond là một mảng
		if(is_array($cond)) {

			// nếu $cond là một mảng dạng: array($field => $value)
			if(!isset($cond[0])) {
				$rs = array('and');
				foreach($cond as $key => $val) {
					// nếu $val là một mảng
					if(is_array($val)) {
						if(count($val)) {
							// nếu $val là một mảng chỉ số 0, 1, 2... thì dùng toán tử in
							if(isset($val[0])) {
								$rs[] = array('in', $key, $val);
							} else {
								// ngược lại thì xét xem có comparator không
								if(isset($val['cp'])) {
									$rs[] = array($val['cp'], $key, $val['value']);
								}
							}
						}
					} else {
						// ngược lại, $val là một giá trị, so sánh bằng
						$rs[] = array($key, $val);
					}
				}
				return $this->build($rs);
			}
			// nếu $cond là mảng dạng array($operator, $key, $value,...) và $operator dạng eq, lt, gt,...
			$op = $cond[0];

			// nếu $op trong danh sách các toán tử logic cho phép
			if(in_array($op, self::$operations)) {
				$func = 'mf_'.$op;
				array_shift($cond);
				return call_user_func_array(array($this, $func), $cond);
			} else {
				// nếu không chỉ định toán tử logic
				if(count($cond) >= 2 ) {
					// nếu cả 2 giá trị đem so sánh không phải mảng thì nó là cặp $key, $value 
					if(!is_array($cond[0]) && !is_array($cond[1])) {
						return call_user_func_array(array($this, 'mf_equal'), $cond);
					} elseif(!is_array($cond[0]) && is_array($cond[1])) {
						return call_user_func_array(array($this, 'mf_in'), $cond);
					} else {
						// ngược lại coi đó là toán tử and
						return call_user_func_array(array($this, 'mf_and'), $cond);
					}
				}
				return $op;
			}
		} else {
			return $cond;
		}
	}
	
	public function mf_sql($sql) {
		return $sql;
	}

	function mf_column($col, $col2 = null) {
		if(preg_match('/^`[\w][\w\d]*`$/', $col)) {
			return $col;
		}
		if(preg_match('/^`[\w][\w\d]*`\.`[\w][\w\d]*`$/', $col)) {
			return $col;
		}
		if(preg_match('/^[\w][\w\d]*\.[\w][\w\d]*$/', $col)) {
			return $col;
		}
		if(!$col2)
			return '`' . @mysql_escape_string($col) . '`';
		return '`' . @mysql_escape_string($col) . '`.`' . @mysql_escape_string($col2) . '`';
	}
	function mf_string($str) {
		return '\'' . @mysql_escape_string($str) . '\'';
	}
	function mf_equal($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'=' . $this->build($exp2) . ')';
	}

	function mf_like($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .' like ' . $this->build($exp2) . ')';
	}

	function mf_notlike($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .' not like ' . $this->build($exp2) . ')';
	}

	function mf_exp($op) {
		$args = func_get_args();
		$op = $args[0];
		array_shift($args);
		$args_count = count($args);
		if(!$args_count) {
			return '1';
		}
		if($args_count == 1) {
			return '(' . $this->build($args[0]) . ')';
		}
		$conds = array();
		foreach($args as $exp) {
			$conds[] = $this->build($exp);
		}
		return '(' . implode(' '.$op.' ', $conds) . ')';
	}

	function mf_and() {
		$args = func_get_args();
		array_unshift($args, 'and');
		return call_user_func_array(array($this, 'mf_exp'), $args);
	}

	function mf_or() {
		$args = func_get_args();
		array_unshift($args, 'or');
		return call_user_func_array(array($this, 'mf_exp'), $args);
	}
	
	function mf_in($col, $arr) {
		if(!is_array($arr)) {
			return false;
		}
		if(!count($arr)) {
			return '1';
		}
		$col = $this->mf_makecol($col);
		return $col. ' in (' . implode(', ', $arr) . ')';
	}
	
	function mf_notin($col, $arr) {
		if(!is_array($arr)) {
			return false;
		}
		if(!count($arr)) {
			return '1';
		}
		$col = $this->mf_makecol($col);
		return $col. ' not in (' . implode(', ', $arr) . ')';
	}
	
	function mf_isnull($col) {
		$col = $this->mf_makecol($col);
		return $col. ' is null';
	}
	
	function mf_isnotnull($col) {
		$col = $this->mf_makecol($col);
		return $col. ' is not null';
	}
	
	function mf_makecol($col) {
		if (is_string($col)) {
			return $this->mf_column($col);
		} else if (is_array($col)) {
			return $this->build($col);
		}
	}
	
	function mf_gt($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'>' . $this->build($exp2) . ')';
	}
	function mf_gte($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'>=' . $this->build($exp2) . ')';
	}
	function mf_lt($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'<' . $this->build($exp2) . ')';
	}
	function mf_lte($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'<=' . $this->build($exp2) . ')';
	}
}