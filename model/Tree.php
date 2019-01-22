<?php
class TreeModel {
	public function getTree($table, $conditions = '1') {
		$items = _db()->select('*')->from($table)->where($conditions)->orderBy('code ASC')->result();
		return $this->treepify($items);
	}
	
	public function treepify($items) {
		$items = $this->index($items);
		return $this->tree($items);
	}

	public function index($items) {
		$rslt = array();
		foreach($items as $item) {
			$rslt[$item['id']] = $item;
		}
		return $rslt;
	}

	public function tree($items) {
		$roots = array();
		foreach($items as $id => &$item) {
			if ($item['parentId'] != 0) {

				if (!isset($items[$item['parentId']])) continue;

				if (!isset($items[$item['parentId']]['items']))
				$items[$item['parentId']]['items'] = array();

				$items[$item['parentId']]['items'][$id] = &$item;
			} else {
				$roots[$id] = &$item;
			}
		}
		return $roots;
	}
}
?>