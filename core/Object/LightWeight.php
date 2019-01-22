<?php
class PzkObjectLightWeight {
	public function __construct($attrs) {
		foreach($attrs as $key => $value) $this->$key = $value;
		$this->children = array();
		if (!@$this->id) {
			$this->id = 'uniqueId' . PzkObject::$maxId;
			PzkObject::$maxId++;
		}
	}
	
	public function init() {
	}
	
	public function finish() {
	}
	
	public function display() {
		foreach($this->children as $child) {
			$child->display();
		}
	}
	
	/**
	 *	Append mot child object 
	 */
	public function append($obj) {
		$obj->pzkParentId = @$this->id;
		$this->children[] = $obj;
	}
}