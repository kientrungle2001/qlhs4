<?php
/**
 * 
 * @author Lê Trung Kiên
 *
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

	class PzkTableController extends PzkController {

	public $tables = array();
	public $inserts = array();
	public $constraints = array();
	public $filters = array();
	public $deletes = array();
	public $statusDeletes = array();
	public $exports = array();
	public $export_sets = array();
	public $export_metadata = array();
	public $onEdit = array();
	public $onAdd = array();
	public $onDel = array();
	public $pkeys = array();
	

	/**
	 * Lấy dữ liệu về dạng json
	 */
	public function jsonAction() {
		set_time_limit(0);
		$table = @$_REQUEST['table'];
		$oldTable = $table;
		// trường cần lấy
		$fields = @$this->tables[$table] ? @$this->tables[$table] : '*';

		// filter kiểu cũ
		$filters = @$this->filters[$table];

		// filter kiểu mới
		$cbFilters = @$this->filters[$table . '_filter'];
		$groupBy = false;
		$defaultOrderBy = false;
		$arrFields = array();
		$defaultConds = '1';
		if (is_array($fields)) {
			$arrFields = $fields;
			$table = @$fields['table']?$fields['table']: $oldTable;
			$groupBy = isset($fields['groupBy']) ? $fields['groupBy'] : false;
			$defaultOrderBy = isset($fields['orderBy']) ? $fields['orderBy'] : false;
			$defaultConds = isset($fields['conds']) ? $fields['conds'] : '1';
			$fields = @$fields['fields']?@$fields['fields']: '*';
		} else {

		}
		$conds = array();
		$havingConds = array();
		$cbWhereConds = false;
		$cbHavingConds = false;
		
		/**
		 * Filter dữ liệu từ request
		 */
		if (isset($_REQUEST['filters'])) {
			if (!$filters) {
				// Nếu không khai báo filters, thì filters sẽ lấy tự động từ request
				foreach($_REQUEST['filters'] as $key => $value) {
					// Nếu filter khác trống
					if($value !== '') {
						$conds[$key] = $value;
					} else {
						// tất cả
					}
				}
				// $conds = array_merge($conds, $_REQUEST['filters']);
			} else {
			 // Nếu có khai báo filters
				foreach ($filters as $key => $options) {
				 // nếu không có filter của một trường hoặc trường truyền filter lên có giá trị trống thì bỏ qua
					if(!isset($_REQUEST['filters'][$key]) || isset($_REQUEST['filters'][$key]) && $_REQUEST['filters'][$key] == '') continue;
					
					if(is_array($options)) {
						// nếu khai báo filter cho trường dạng comparator => field
						foreach ($options as $comp => $field) {
							// nếu field là mảng và có having
							if(is_array($field)) {
								if(isset($field['having']) && $field['having'] == true) {
									if (!!@$_REQUEST['filters'][$key]) {
										$havingConds[] = array($field['name'] => array('cp' => $comp, 'value' => @$_REQUEST['filters'][$key]));
									}
								}
							} else {
								// nếu có giá trị lọc
								if (!!@$_REQUEST['filters'][$key]) {
									$conds[] = array($field => array('cp' => $comp, 'value' => @$_REQUEST['filters'][$key]));
								}
							}
						}
					} else {
						// nếu $options là một chuỗi
						// nếu có giá trị lọc
						if (!!@$_REQUEST['filters'][$key]) {
							$conds[] = array($field => array('cp' => $options, 'value' => @$_REQUEST['filters'][$key]));
						}
					}
					
				}
			}
			
			/**
			 * Filter dữ liệu từ request theo kiểu mới
			 */
			if ($cbFilters) {
				if(isset($cbFilters['where'])) {
					foreach ($cbFilters['where'] as $key => $options) {
						if(!isset($_REQUEST['filters'][$key]) || isset($_REQUEST['filters'][$key]) && $_REQUEST['filters'][$key] == '') continue;
						if(!$cbWhereConds) {
							$cbWhereConds = array('and'
							// ,array('equal', array('string', '1'), array('string', '1'))
							// ,array('equal', array('string', '1'), array('string', '1'))
							);
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
		
        # Tính total
		$total = _db()->select('count(*) as val')->from($table);
		if(empty($conds)) {
			$conds = 1;
		}
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
		
		# sắp xếp
		$orderBy = array();
		$sort = explode(',', @$_REQUEST['sort']);
		$order = explode(',', @$_REQUEST['order']);
		foreach ($sort as $index => $sortField) {
		    $orderBy[] = $sortField . ' ' . $order[$index];
		}
		$orderBy = implode(',', $orderBy);
		if (!trim($orderBy)) {
			$orderBy = $defaultOrderBy ? $defaultOrderBy: 'id desc';
		}
		
		# lấy ra các bản ghi
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
		
		# export dữ liệu
		if($type = @$_REQUEST['export']) {
			if($type == 'json') {
				$ext = 'json';
			} elseif($type == 'excel' || $type == 'xlsx') {
				$ext = 'xlsx';
			} elseif($type == 'csv') {
				$ext = 'csv';
			} elseif($type == 'html') {
				$ext = 'html';
			} else {
				$ext = 'json';
			}
			$rand = rand(0, 1000000000000);
			$file = '/cache/export-' .date('YmdHis'). '-' .$rand.'.' . $ext;
			// export dữ liệu theo options chứa fields và childTables
			if(isset($_REQUEST['export_set']) && isset($this->export_sets[$_REQUEST['table']][$_REQUEST['export_set']])) {
				$options = $this->export_sets[$_REQUEST['table']][$_REQUEST['export_set']];
			} else {
				$options = $_REQUEST['options'];
			}

			$items = $this->buildExportData($table, $items, $options);

			if($ext == 'json') {
				file_put_contents(BASE_DIR . $file, '');
				foreach($items as $row) {
					file_put_contents(BASE_DIR . $file, json_encode($row, JSON_UNESCAPED_UNICODE) . "\r\n", FILE_APPEND);
				}
			} elseif($ext == 'csv') {
				file_put_contents(BASE_DIR . $file, '');
				if(count($items)) {
					$firstRow = $items[0];
					$fields = array_keys($firstRow);
					file_put_contents(BASE_DIR . $file, csvstr($fields) . "\r\n", FILE_APPEND);
				}
				foreach($items as $row) {
					$line = csvstr(array_values($row));
					file_put_contents(BASE_DIR . $file, $line . "\r\n", FILE_APPEND);
				}
			} elseif($ext == 'xlsx') {
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				sheet_set_column_width($sheet, $options);
				array_to_sheet($items, $sheet, $options);

				$writer = new Xlsx($spreadsheet);
				$writer->save(BASE_DIR .$file);
			} elseif($ext == 'html') {
				file_put_contents(BASE_DIR . $file, '<!DOCTYPE html><html>
<head>
	<title>Quản trị</title>
	<meta name="google-site-verification" content="DJBoN802jfeoHdZJX1oM0vqdSuVjiqQ_0t4dHq0zEf4" />
	<meta content="width=device-width, height=device-height initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"  name="viewport"  />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="canonical" href="http://phattrienngonngu.com/" />
</head>
<body>

				<table border="1" style="border-collapse: collapse">'."\r\n");
				if(count($items)) {
					$firstRow = $items[0];
					$fields = array_keys($firstRow);
					file_put_contents(BASE_DIR . $file, trstr($fields) . "\r\n", FILE_APPEND);
				}
				foreach($items as $row) {
					$line = trstr(array_values($row));
					file_put_contents(BASE_DIR . $file, $line . "\r\n", FILE_APPEND);
				}
				file_put_contents(BASE_DIR . $file, "</table></body></html>", FILE_APPEND);
			}

			if (file_exists(BASE_DIR . $file)) {
				echo json_encode(['file' => BASE_URL . $file, 'query' => $query]);
			}
			//unlink($file);
		} else {
			echo json_encode($data);
		}
		
	}

	/**
	 * Xây dựng dữ liệu cho export
	 * @param string $table
	 * @param array $items
	 * @param array $options chứa fields(index => string, title => string) và childTables
	 * @param boolean $isMainTable
	 * @return array[]
	 */
	public function buildExportData($table, $items, $options, $isMainTable = true) {
		$result = array();
		$fields = $options['fields'];
		$childTables = @$options['childTables'];
		foreach($items as $item) {
			$exportItem = $this->buildExportItem($table, $item, $fields);
			if($isMainTable && $childTables) {
				$exportItem['childTables'] = array();
				foreach($childTables as $childTable) {
					$exportItem['childTables'][$childTable['table']] = array();
					$childTableItems = _db()->select('*')
							->from($childTable['table'])
							->where(array('equal', $childTable['referenceField'], $item['id']))
							->result();
							$exportChildTableItems = $this->buildExportData($childTable['table'], $childTableItems, $childTable, false);
					$exportItem['childTables'][$childTable['table']] = $exportChildTableItems;
				}
			}
			$result[] = $exportItem;
		}
		return $result;
	}

	/**
	 * Xây dựng bản ghi để export
	 * @param string $table
	 * @param array $item
	 * @param array $fields
	 * @return NULL[]
	 */
	public function buildExportItem($table, $item, $fields) {
		$result = array();
		foreach($fields as $field) {
			if($field['title']) {
				$fieldName = $field['title'];
			} else {
				$fieldName = $field['index'];
			}
			if(@$field['type'] == 'date') {
				//$result[$fieldName] = '=datevalue("' . date('Y-m-d', strtotime(@$item[$field['index']])) . '")';
				$result[$fieldName] = @$item[$field['index']];
			} elseif(@$field['type'] == 'money') {
				$result[$fieldName] = product_price(@$item[$field['index']]);
			} elseif(@$field['type'] == 'map') {
				$map = @$field['map'];
				$result[$fieldName] = @$map[@$item[$field['index']]];
			} else {
				$result[$fieldName] = @$item[$field['index']];
			}
		}
		return $result;
	}
	
	/**
	 * Trả về dữ liệu theo id
	 */
	public function getAction() {
		$id = @$_REQUEST['id'];
		$fields = @$_REQUEST['fields'];
		if(!$fields) {
			$fields = '*';
		}
		$row = _db()->select($fields)->from(@$_REQUEST['table'])->where(array('equal', 'id', $id))->result_one();
		echo json_encode($row);
	}
	
	/**
	 * Trả về dữ liệu dạng cây
	 */
	public function treejsonAction() {
		//$_REQUEST['showSQL'] = 1;
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$table = @$_REQUEST['table'];
		$fields = @$this->tables[$table] ? @$this->tables[$table] : '*';
		// $filters = @$this->filters[$table];
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
		foreach ($sort as $index => $sortField) {
		    $orderBy[] = $sortField . ' ' . $order[$index];
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
	
	/**
	 * Check xem bản ghi có bản ghi con không
	 * @param string $table
	 * @param string $id
	 * @return boolean
	 */
	public function _hasChild($table, $id) {
		$rs = mysql_query("select count(*) from `$table` where parentId=$id");
		$row = mysql_fetch_array($rs);
		return $row[0] > 0 ? true : false;
	}

	/**
	 * Cập nhật một bản ghi
	 */
	public function editAction() {
		$table = @$_REQUEST['table'];
		$_REQUEST['id'] = intval($_REQUEST['id']);
		$fields = @$this->inserts[$table] ? @$this->inserts[$table] : array();
		$data = array();

		// lọc dữ liệu update theo fields
		foreach ($fields as $field) {
			if (isset($_REQUEST[$field])) {
				$data[$field] = $_REQUEST[$field];
			}
		}
		/*
		foreach($fields as $field) {
			if(!isset($data[$field])) $data[$field] = null;
		}*/
		
		// xây dựng dữ liệu để cập nhật
		$data = _db()->buildInsertData($table, $data);
		_db()->update($table)
				->set($data)->where('id=' . $_REQUEST['id'])->result();
		
		// xử lý sự kiện sau khi cập nhật
		if(isset($this->onEdit[$table])) {
		    $onUpdateMethod = $this->onEdit[$table];
		    $this->$onUpdateMethod($table, $data, $_REQUEST['id']);
		}
		if($table == 'class_student' || $table=='student_order') {
			$student = _db()->getEntity('edu.student')->load($data['studentId']);
			if($student->getId()) {
				$student->gridIndex();
			}
		} else if($table == 'student') {
			$student = _db()->getEntity('edu.student')->load($_REQUEST['id']);
			if($student->getId()) {
				$student->gridIndex();
			}
		}
		$row = _db()->select('*')
				->from($table)
				->where(array('equal','id', $_REQUEST['id']))
				->result_one();
		echo json_encode(array(
			'errorMsg' => false,
			'data' => $row
		));
	}

	/**
	 * Thêm bản ghi mới
	 * @return boolean
	 */
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
		foreach($fields as $field) {
			if(!isset($data[$field])) $data[$field] = null;
		}
		$data = _db()->buildInsertData($table, $data);
		$id = _db()->insert($table)
				->fields(implode(',', $fields))
				->values(array($data))->result();
    	if(isset($this->onAdd[$table])) {
    	    $onUpdateMethod = $this->onAdd[$table];
    	    $this->$onUpdateMethod($table, $data, $id);
    	}
    	
    	# update lại student
		if($table == 'class_student'  || $table=='student_order') {
			$student = _db()->getEntity('edu.student')->load($data['studentId']);
			if($student->getId()) {
				$student->gridIndex();
			}
		} else if($table == 'student') {
			$student = _db()->getEntity('edu.student')->load($id);
			if($student->getId()) {
				$student->gridIndex();
			}
		}
		$row = _db()->select('*')
				->from($table)
				->where(array('equal','id', $id))
				->result_one();
		echo json_encode(array(
			'errorMsg' => false,
			'data' => $row
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
				if(isset($this->onDel[$table])) {
				    $onUpdateMethod = $this->onDel[$table];
				    $this->$onUpdateMethod($table, $_REQUEST['id']);
				}
				if($table == 'class_student' || $table=='student_order') {
					$data = _db()->useCB()->select('*')->from($table)->whereId($_REQUEST['id'])->result_one();
					$student = _db()->getEntity('edu.student')->load($data['studentId']);
					if($student->getId()) {
						$student->gridIndex();
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
				if(isset($this->onDels[$table])) {
				    $onUpdateMethod = $this->onDels[$table];
				    $this->$onUpdateMethod($table, $_REQUEST['ids']);
				}
				if($table == 'class_student' || $table=='student_order') {
					foreach($_REQUEST['ids'] as $id) {
						$data = _db()->useCB()->select('*')->from($table)->whereId($id)->result_one();
						$student = _db()->getEntity('edu.student')->load($data['studentId']);
						if($student->getId()) {
							$student->gridIndex();
						}	
					}
				}
				if($table == 'general_order') {
					foreach($_REQUEST['ids'] as $id) {
						$student_order = _db()->select('*')->from('student_order')->whereOrderId($id)->result_one();
						if($student_order) {
							$student = _db()->getEntity('edu.student')->load($student_order['studentId']);
							if($student->getId()) {
								$student->gridIndex();
							}
						}
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
			$data = _db()->useCB()->select('*')->from($table)->whereId($_REQUEST['id'])->result_one();
			_db()->delete()->from($table)->where('id=' . $_REQUEST['id'])->result();
			$deletions = @$this->deletes[$table];
			if($deletions) {
				foreach($deletions as $delTable => $refField) {
					_db()->delete()->from($delTable)->where( $refField . '=' . $_REQUEST['id'])->result();
				}
			}
			if($table == 'class_student' || $table=='student_order') {
				$student = _db()->getEntity('edu.student')->load($data['studentId']);
				if($student->getId()) {
					$student->gridIndex();
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
			
			if($table == 'class_student' || $table=='student_order') {
				foreach($_REQUEST['ids'] as $id) {
					$data = _db()->useCB()->select('*')->from($table)->whereId($id)->result_one();
					$student = _db()->getEntity('edu.student')->load($data['studentId']);
					if($student->getId()) {
						$student->gridIndex();
					}	
				}
			}
			if($table == 'general_order') {
				foreach($_REQUEST['ids'] as $id) {
					$student_order = _db()->select('*')->from('student_order')->whereOrderId($id)->result_one();
					if($student_order) {
						$student = _db()->getEntity('edu.student')->load($student_order['studentId']);
						if($student->getId()) {
							$student->gridIndex();
						}
					}
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
					$item = _db()->useCB()->select('*')->from($table);
					$key = $constraint['key'];
					foreach ($key as $field) {
						$item->where(array($field, $data[$field]));
					}
					
					$item = $item->result_one();
					if ($item) {
						$constraint['row'] = $item;
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
		$id = null;
		if ($result = $this->checkConstraints($table, $data)) {
			_db()->update($table)
					->set($data)->where('id=' . $result['row']['id'])->result();
			$id = $result['row']['id'];
		} else {
			$id = _db()->insert($table)
					->fields(implode(',', $fields))
					->values(array($data))->result();
		}
		
		$row = null;
		if($id) {
			$row = _db()->select('*')->from($table)->where(array('equal', 'id', $id))->result_one();
		}
		
		echo json_encode(array(
			'errorMsg' => false,
			'success' => true,
			'data' => $row
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
			if($table == 'class_student' || $table=='student_order') {
				$data = _db()->useCB()->select('*')->from($table)->whereId($_REQUEST['id'])->result_one();
				$student = _db()->getEntity('edu.student')->load($data['studentId']);
				if($student->getId()) {
					$student->gridIndex();
				}
			}
		} else {
			if ($result = $this->checkConstraints($table, $data)) {
				_db()->update($table)
						->set($data)->where('id=' . $result['row']['id'])->result();
				if($table == 'class_student' || $table=='student_order') {
					$data = _db()->useCB()->select('*')->from($table)->whereId($result['row']['id'])->result_one();
					$student = _db()->getEntity('edu.student')->load($data['studentId']);
					if($student->getId()) {
						$student->gridIndex();
					}
				}
			}
		}
		echo json_encode(array(
			'errorMsg' => false,
			'success' => true
		));
	}

	public function allAction() {
		$table = $_REQUEST['table'];
		$fromId = isset($_REQUEST['from_id']) ? $_REQUEST['from_id']: '0';
		$rows = _db()->useCB()->select('*')->from($table)->where(['gte', 'id', $fromId])->result();
		$this->jprint('');
		foreach($rows as $row) {
			$this->jprint(json_encode($row, JSON_UNESCAPED_UNICODE) . "\r\n", true);
		}
		echo BASE_URL . '/cache/' . $table . '.txt';
	}

	public function jprint($str, $append = false) {
		$table = $_REQUEST['table'];
		if($append) {
			file_put_contents(BASE_DIR . '/cache/' . $table . '.txt', $str, FILE_APPEND);
		} else {
			file_put_contents(BASE_DIR . '/cache/' . $table . '.txt', $str);
		}
	}

	public function importAction() {
		$item = $_REQUEST['item'];
		$options = $_REQUEST['options'];
		$table = $_REQUEST['table'];
		$type = $_REQUEST['type'];
		$keys = @$options['keys'];
		if($type == 'insert') {
			$fields = array_keys($item);
			$values = array_values($item);
			if(isset($item['id'])) unset($item['id']);
			$entity = _db()->getTableEntity($table);
			$entity->setData($item);
			$entity->save();
			$result = array(
				'success' 	=> true,
				'insertedId' 	=> $entity->getId()
			);
			echo json_encode($result);
		}else {
			if($keys && count($keys)) {
				$query = _db()->select('*')->from($table);
				foreach($keys as $key) {
					$query->where(array('equal', $key, $item[$key]));
				}
				$row = $query->result_one();
				if($row) {
					$entity = _db()->getTableEntity($table);
					$entity->load($row['id']);
					foreach($item as $key => $value) {
						if($key !== 'id')
							$entity->set($key, $value);
					}
					$entity->save();
					$result = array(
						'success' 	=> true,
						'updatedId' 	=> $entity->getId()
					);
					echo json_encode($result);
				}
			} else {
				$entity = _db()->getTableEntity($table);
				$entity->load($item['id']);
				foreach($item as $key => $value) {
					if($key !== 'id')
						$entity->set($key, $value);
				}
				$entity->save();
				$result = array(
					'success' 	=> true,
					'updatedId' 	=> $entity->getId()
				);
				echo json_encode($result);
			}
		}
		
	}

	public function importExcelAction() {
		$table = $_REQUEST['table'];
		$file = $_REQUEST['file'];
		$import_set = $_REQUEST['import_set'];
		// do import into table
			// read data from file
			// load import config set
			// foreach data
				// import each row by config
	}

	public function fieldsAction() {
		$table = $_REQUEST['table'];
		$fields = _db()->getFields($table);
		echo json_encode($fields);
	}

	public function distinctAction() {
		$table = $_REQUEST['table'];
		$field = $_REQUEST['field'];
		$items = _db()->select('distinct(`'.$field.'`)')->from($table)->result();
		$result = array();
		foreach($items as $item) {
			$result[] = $item[$field];
		}
		echo json_encode($result);
	}

	public function exportConfigAction() {
		$table = $_REQUEST['table'];
		$config = @$this->exports[$table];
		echo json_encode($config);
	}

}
function array_to_sheet(&$array, &$sheet, $options) {
	file_put_contents(BASE_DIR.'/array_to_sheet.txt', '');
	file_put_contents(BASE_DIR.'/array_to_sheet.txt', var_export($array, true), FILE_APPEND);
	file_put_contents(BASE_DIR.'/array_to_sheet.txt', var_export($options, true), FILE_APPEND);
	$columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 
	'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 
	'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 
	'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 
	'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 
	'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 
	'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 
	'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');
	$columnIndex = 0;
	$person = $array[0];	
	foreach($person as $prop => $value) {
		$sheet->setCellValue($columns[$columnIndex] . 1, $prop);
		$sheet->getStyle($columns[$columnIndex] . 1)->getFont()->setBold(true);
		$columnIndex++;
	}

	foreach($array as $index => $person) {
		foreach($options['fields'] as $columnIndex => $field) {
			$value = $person[pzk_or(@$field['title'], @$field['index'])];
			if(isset($options['fields'][$columnIndex]['type']) && $options['fields'][$columnIndex]['type'] == 'date') {
				$value = new DateTime($value);
				if(isset($options['fields'][$columnIndex]['dateType']) && $options['fields'][$columnIndex]['dateType'] == 'formula') {
					$sheet->setCellValue($columns[$columnIndex] . ($index + 2),'= datevalue("'. $value->format('m/d/Y') . '")');
				} elseif(isset($options['fields'][$columnIndex]['dateType']) && $options['fields'][$columnIndex]['dateType'] == 'date') {
					$sheet->setCellValue($columns[$columnIndex] . ($index + 2), $value->format($options['fields'][$columnIndex]['format']));
				} else {
					$sheet->setCellValue($columns[$columnIndex] . ($index + 2), \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(gmstrtotime($value->getTimestamp())));
					$sheet->getStyle($columns[$columnIndex] . ($index + 2))
    		->getNumberFormat()
    		->setFormatCode(pzk_or(@$options['fields'][$columnIndex]['format'], 'dd/mm/yyyy'));
				}
			} else {
				$sheet->setCellValue($columns[$columnIndex] . ($index + 2), $value);
			}
			//$sheet->getStyle($columns[$columnIndex] . ($index + 2))->getAlignment()->setWrapText(true);			
		}
		//$sheet->getRowDimension(($index + 2))->setRowHeight(-1);
	}
}

function sheet_set_column_width(&$sheet, $options) {
	$columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 
	'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 
	'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 
	'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 
	'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 
	'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 
	'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 
	'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');
	foreach($options['fields'] as $index => $field) {
		if(isset($field['width'])) {
			$column = $sheet->getColumnDimension($columns[$index]);
			$column->setWidth($field['width']);
		}
	}
}