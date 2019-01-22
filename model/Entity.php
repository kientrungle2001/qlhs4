<?php
class PzkEntityModel {
	public $data = array();
	public $table;
	public $type = '';
	public function setData($data) {
		$this->data = $data;
		return $this;
	}
	public function getData() {
		return $this->data;
	}
	public function load($id = false, $cacheTimeout = NULL) {
		if($id) {
			$query = _db();
			if($cacheTimeout) {
				$query->useCache($cacheTimeout);
			}
			$this->data = $query->select('*')->from($this->table)->where('id=' . $id)->result_one();
		}
		return $this;
	}
	public function loadWhere($conditions, $cacheTimeout = NULL) {
		if($conditions) {
			$query = _db();
			if($cacheTimeout) {
				$query->useCache($cacheTimeout);
			}
			$this->data = $query->useCB()->select('*')->from($this->table)->where($conditions)->result_one();
			//echo $query->getQuery();
		}
		return $this;
	}

	public function update($data) {
		$this->data = array_merge($this->data, $data);
		foreach($data as $key => &$value) {
			if($value === NULL) {
				$value = '';
			}
		}
		$data = _db()->buildInsertData($this->table, $this->data);
		_db()->update($this->table)->set($data)->where('id=' . $this->data['id'])->result();
	}
	public function save() {
		$data = _db()->buildInsertData($this->table, $this->data);
		if(!isset($this->data['id'])) {
			$keys = array_keys($data);
			foreach($keys as &$key) {
				$key = "`$key`";
			}
			$id = _db()->insert($this->table)->fields(implode(',', $keys))->values(array($data))->result();
			if($id) $this->data['id'] = $id;
		} else {
			_db()->update($this->table)->set($data)->where('id=' . $this->data['id'])->result();
		}
		//$this->children('updateClosure');
		//$this->updateClosure();
	}
	public function updateClosure() {
		if(isset($this->data['parentId'])) {
			$parentId = $this->data['parentId'];
			if($parentId) {
				$class = get_class($this);
				$obj = new $class();
				$obj->load($parentId);
				$closure = $obj->get('closure','') . $this->get('id') . ',';
			} else {
				$closure = ','.$this->get('id') . ',';
			}
			$this->data['closure'] = $closure;
			$closureData = array(
				'closure' => $closure
			);
			$this->update($closureData);
		}
		
	}
	
	public function getRelateds($table, $entity, $refField, $conditions = false) {
		$query = _db()->select('*')->from($table)->where($refField . '=' . $this->data['id']);
		if($conditions) {
			$query->useCB()->where($conditions);
		}
		return $query->result($entity);
	}
	/*
	public function getType() {
		$typeCode = $this->type;
		if(!$typeCode) $typeCode = str_replace('_', '', $this->table) . 'Table';
		$type = _db()->useCB()->select('*')->from('attribute_catalog_type')
				->where(array('and', array('sourceTable', $this->table), array('code', $typeCode)))->result_one('attribute.catalog.type');
		return $type;
	}*/
	
	public function get($key, $default = NULL) {
		return isset($this->data[$key]) && $this->data[$key]?$this->data[$key]: $default;
	}
	
	public function set($key, $value) {
		$this->data[$key] = $value;
		return $this;
	}
	
	public function has($key) {
		return isset($this->data[$key]);
	}
	
	public function children($action = false) {
		if($action) {
			if(gettype($action) == 'string') {
				if(method_exists($this, $action)) {
					$this->$action();
				} else {
					$action($this);
				}
			} else if(gettype($action) == 'object') {
				$action->process($this);
			}
		}
		
		$type = $this->getType();
		if(!$type) return false;
		$relations = $type->getRelations();
		
		foreach($relations as $rel) {
			$related = $rel->getRelatedType();
			$relation = $rel->getRelationType();
			$parentField = $rel->getAttribute();
			if($relation->get('code') == 'Parent') {
				$children = _db()->useCB()->select('*')->from($related->get('sourceTable'))
					->where(array($parentField->get('code') , $this->get('id')))->result(str_replace('_', '.', $related->get('sourceTable')));
				
				foreach($children as $child) {
					$child->children($action);
				}
			}
		}
	}
	
	public function delete() {
		return _db()->useCB()->delete()->from($this->table)
		->where(array('id', $this->get('id')))->result();
	}
	
	public function __call($name, $arguments) {

		//Getting and setting with $this->property($optional);

		if (property_exists(get_class($this), $name)) {


			//Always set the value if a parameter is passed
			if (count($arguments) == 1) {
				/* set */
				$this->set($name, $arguments[0]);
			} else if (count($arguments) > 1) {
				throw new \Exception("Setter for $name only accepts one parameter.");
			}

			//Always return the value (Even on the set)
			return $this->get($name);
		}

		//If it doesn't chech if its a normal old type setter ot getter
		//Getting and setting with $this->getProperty($optional);
		//Getting and setting with $this->setProperty($optional);
		$prefix = substr($name, 0, 3);
		$property = strtolower($name[3]) . substr($name, 4);
		switch ($prefix) {
			case 'get':
				return $this->get($property, @$arguments[0]);
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->set($property, $arguments[0]);
				//Always return this (Even on the set)
				return $this;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
	
	public function getWhere($where = 1, $orderBy = 'id asc'){
		$arr = array();
		$class = get_class($this);
		$items = _db()->useCB()->select('*')->from($this->table)->where($where)->orderBy($orderBy)->result();
		foreach($items as $item) {
			$entity = new $class();
			$entity->table = $this->table;
			$entity->setData($item);
			$arr[] = $entity;
		}
		return $arr;
	}
	public function getOne($where = 1, $orderBy = 'id asc'){
		$item = _db()->useCB()->select('*')->from($this->table)->where($where)->orderBy($orderBy)->result_one();
		if($item) {
			$class = get_class($this);
			$entity = new $class();
			$entity->table = $this->table;
			$entity->setData($item);
			return $entity;
		}
		return null;
	}
}