<?php
class PzkCoreJQuery extends PzkObjectLightWeight {
	public $id = 'jQuery';
	public $selector;
	public $actions = array();
	public function setSelector($selector) {
		$this->selector = $selector;
		return $this;
	}
	public function addAction($name, $data) {
		$this->actions[] = array('name' => $name, 'data' => $data);
	}
	public function display() {
		$str = "jQuery('{$this->selector}')";
		foreach ($this->actions as $action) {
			$str .= '.' .$action['name'].'(' . json_encode($action['data']) . ')';
		}
		$str .= ';';
		echo $str;
	}
	public function html($data = NULL) {
		$this->addAction('html', $data);
		return $this;
	}
	public function text($data = NULL) {
		$this->addAction('text', $data);
		return $this;
	}
}

/**
 * Trả về đối tượng PzkCoreJQuery
 * @param string $selector
 */
function jQuery($selector) {
	return pzk_element('jQuery')->setSelector($selector);
}