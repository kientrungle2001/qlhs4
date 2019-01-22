<?php
class DbConfig {
	public $db = '';
	public $host = '';
	public $port = '';
	public $user = '';
	public $pass = '';
	public function __construct($host, $port, $user, $pass, $db) {
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->pass = $pass;
		$this->db 		= $db;
	}
}

class DbConnection {
	public $config;
	public $connection;
	public $selectBuilder;
	public function __construct($config, $connect = true, $autoBuilder = true) {
		$this->setConfig($config);
		
		if($connect) {
			$this->connect();
			
		}
		if($autoBuilder) {
			$this->setSelectBuilder(new DbSelectBuilder());
		}
	}
	public function setConfig($config) {
		$this->config = $config;
		return $this;
	}
	public function setSelectBuilder($selectBuilder) {
		$this->selectBuilder = $selectBuilder;
	}
	public function connect() {
		$this->connection = mysqli_connect($this->config->host . ':' . $this->config->port, $this->config->user, $this->config->pass) or die('could not connect');
		mysqli_select_db($this->connection, $this->config->db) or die('cant not select db');
		return $this;
	}
	public function exec($query) {
		return mysqli_query($this->connection, $query);
	}
	public function fetch($result) {
		return mysqli_fetch_assoc($result);
	}
	public function select($table = null) {
		$query = new DbSelectQuery($table);
		$query->setConnection($this);
		$query->setBuilder($this->selectBuilder);
		return $query;
	}
	public function import($file, $table, $constrains) {
		$content = file_get_contents($file);
		$data = json_decode($content, true);
		$insertions = [];
		foreach($data as $row) {
			// TODO: Build Conditions
			$conds = '';
			$record = $this->select($table)->where($conds)->resultOne();
			if(!$record) {
				$insertions[] = $row;
			} else {
				$record->update($row);
			}
		}
		if(count($insertions)) {
			$this->insert($table)->values($insertions)->result();
		}
	}
}

class DbParams {
	public $start;
	public $skip;
	public $fields = '*';
	public function setLimit($start, $skip) {
		$this->start = $start;
		$this->skip = $skip;
		return $this;
	}
	public function setFields($fields) {
		$this->fields = $fields;
		return $this;
	}
	public function setTable($table) {
		$this->table = $table;
		return $this;
	}
}

class DbSelectBuilder {
	public function build($params) {
		$fields = $params->fields;
		$table = $params->table;
		$conds = 1;
		$start = $params->start;
		$skip = $params->skip;
		return "select $fields from $table where $conds limit $start, $skip";
	}
}

class DbQuery{
	public $query;
	public $builder;
	public $params;
	public $connection;
	public function getQuery() {
		$this->query = $this->builder->build($this->params);
		return $this->query;
	}
	public function setConnection($connection) {
		$this->connection = $connection;
		return $this;
	}
	public function setBuilder($builder) {
		$this->builder = $builder;
		return $this;
	}
	public function setParams($params) {
		$this->params = $params;
		return $this;
	}
}

class DbSelectQuery extends DbQuery {
	public function __construct($table = null) {
		$this->setParams(new DbParams());
		if($table) {
			$this->from($table);
		}
	}
	public function select($fields) {
		$this->params->setFields($fields);
		return $this;
	}
	public function from($table) {
		$this->params->setTable($table);
		return $this;
	}
	public function where($conds) {
		$this->params->setConds($conds);
		return $this;
	}
	public function orderBy($field, $dir = null) {
		$this->params->setOrderBy($field, $dir);
		return $this;
	}
	public function join($table, $conds, $type = 'inner') {
		$this->params->appendJoin($table, $conds, $type);
		return $this;
	}
	public function having($conds) {
		$this->params->setHavingConds($conds);
		return $this;
	}
	public function limit($start, $skip) {
		$this->params->setLimit($start, $skip);
		return $this;
	} 
	/**
		* Return DbSelectResult
	 */
	public function result($resultClass = null) {
		$query = $this->getQuery();
		$result = $this->connection->exec($query);
		$dbResult = new DbSelectResult($this, true);
		while($row = $this->connection->fetch($result)) {
			$dbRow = new DbSelectResult($this, false);
			$dbRow->data = $row;
			$dbResult->data[] = $dbRow;
		}
		return $dbResult;
	}
	/**
		* Return DbSelectResult
	 */
	public function resultOne($resultClass = null) {
		$this->limit(0, 1);
		$query = $this->getQuery();
		$result = $this->connection->exec($query);
		$dbResult = new DbSelectResult($this, false);
		while($row = $this->connection->fetch($result)) {
			$dbResult->data = $row;
			return $dbResult;
		}
		return null;
	}
}

class DbSelectResult {
	public $multiple = true;
	public $data = [];
	public $query;
	public function __construct($query, $multiple) {
		$this->query = $query;
		$this->multiple = $multiple;
	}
	public function toArray() {
		if($this->multiple === false) {
			return $this->data;
		} else {
			$result = [];
			foreach($this->data as $dbResult) {
				$result[] = $dbResult->toArray();
			}
			return $result;
		}
	}
	public function toJson() {

	}
	public function update($data) {
		$this->query->connection->update($this->query->table)->set($data)->where($this->get('id'))->result();
		foreach($data as $key => $value) {
			$this->data[$key] = $value;
		}
	}
	public function delete() {

	}
	public function load() {

	}
	public function save() {

	}
	public function set($key, $value) {
		
	}
	public function export($file) {
		$file_explode = explode('.', $file);
		if(array_pop($file_explode) == 'json') {
			$arr = $this->toArray();
			file_put_contents($file, json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
		}
	}
}

$config = new DbConfig('fulllook.vn', '3306', 'admin_qlhs', 'nn123456', 'admin_qlhs');
$connection = new DbConnection($config);
#
$users = $connection->select('student')->limit(0, 10)->result();
#
$users->export('./hello.json');
$connection->import('./hello.json', 'student_2', ['phone']);