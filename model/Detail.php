<?php
class DetailModel {
	public function getItem($options) {
		$items = _pzk('element.db')->clear()->select($options['fields'])
			->from($options['table'])->where('id=' . $options['id'])->result();
		if ($items) return $items[0];
	}
}
?>