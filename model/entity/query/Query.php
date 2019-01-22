<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityQueryQueryModel extends PzkEntityModel {
	public $table = 'attribute_catalog';
	public $type = 'Query';
	public function getTables() {
		if(!isset($this->_tables)) {
			$this->_tables = $this->getRelateds('attribute_catalog', 'query.table', 'parentId', array('type', 'QueryJoinTable'));
		}
		return $this->_tables;
	}
	public function getFields() {
		if(!isset($this->_fields)) {
			$this->_fields = $this->getRelateds('attribute_catalog', 'query.field', 'parentId', array('type', 'QueryField'));
		}
		return $this->_fields;
	}
	public function getSet() {
		if(!isset($this->_set)) {
		$this->_set = _db()->getEntity('attribute.set')->load($this->get('setId'));
		}
		return $this->_set;
	}
	public function getImplodedFields() {
		$rs = array();
		$fields = $this->getFields();
		if($alias = $this->get('code')) {
			if($fields)
			foreach($fields as $field) {
				$rs[] = $alias . '.' . $field->get('leftField') . ($field->get('code')? ' as ' . $field->get('code') : '');
			}
			if(!count($rs)) {
				return $alias.'.*';
			}
			return implode(', ', $rs);
		} else {
			if($fields)
			foreach($fields as $field) {
				$rs[] = $field->get('leftField') . ($field->get('code') ? ' as ' . $field->get('code') : '');
			}
			if(!count($rs)) {
				return '*';
			}
			return implode(', ', $rs);
		}
	}
	public function getSQL() {
		$query = $this;
		$querySet = $query->getSet();
		$fields = array();
		$fields[] = $query->getImplodedFields();
		$tables = $query->getTables();
		foreach($tables as $table) {
			$fields[] = $table->getImplodedFields();
		}
		$querySql = 'select ' . implode(', ',$fields) . ' from ' . $querySet->get('code') . ' as ' . $query->get('code');

		if($tables) {
			foreach($tables as $table) {
				$tableSet = $table->getSet();
				$querySql .= "\n".' inner join ' . $tableSet->get('code') . ' as ' . $table->get('code', $tableSet->get('code')) . ' on ' . 
					$query->get('code', $querySet->get('code')) . '.' .  $table->get('rightField') . '=' . $table->get('code', $tableSet->get('code')) 
						. '.' . $table->get('leftField', 'id');
				if($table->get('additionConditions')) {
					$querySql .= ' and ' . $table->get('additionConditions');
				}
			}
		}

		if($query->get('conditions')) {
			$querySql .= ' where ' . $query->get('conditions');
		}
		if($query->get('groupBy')) {
			$querySql .= ' group by ' . $query->get('groupBy');
		}
		if($query->get('havingConditions')) {
			$querySql .= ' having ' . $query->get('havingConditions');
		}
		if($query->get('orderBy')) {
			$querySql .= ' order by ' . $query->get('orderBy');
		}
		return $querySql;
	}
	
	public function getTableSQL() {
		$query = $this;
		$querySet = $query->getSet();
		$tables = $query->getTables();
		$querySql = $querySet->get('code') . ' as ' . $query->get('code');
		if($tables) {
			foreach($tables as $table) {
				$tableSet = $table->getSet();
				$querySql .= "\n".' '.$table->get('joinType', 'inner').' join ' . $tableSet->get('code') . ' as ' . $table->get('code', $tableSet->get('code')) . ' on ' . 
					$query->get('code', $querySet->get('code')) . '.' .  $table->get('rightField', 'id') . '=' . $table->get('code', $tableSet->get('code')) 
						. '.' . $table->get('leftField', 'id');
				if($table->get('additionConditions')) {
					$querySql .= ' and ' . $table->get('additionConditions');
				}
			}
		}
		return $querySql;
	}
	
	public function getFieldsSQL() {
		$query = $this;
		$querySet = $query->getSet();
		$fields = array();
		$fields[] = $query->getImplodedFields();
		$tables = $query->getTables();
		foreach($tables as $table) {
			$fields[] = $table->getImplodedFields();
		}
		return implode(', ', $fields);
	}
}
