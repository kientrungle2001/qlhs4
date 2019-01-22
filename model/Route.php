<?php
class RouteModel {
	public function route($alias) {
		if ($alias) {
			$items = _db()
					->select('*')
					->from('route')->where('alias=\'' . mysql_escape_string($alias) . '\'')->result();
			if ($items) return $items[0];
		}
		return false;
	}
}
?>