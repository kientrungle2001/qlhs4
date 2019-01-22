<?php
class ListModel {
	
	public function getItems($options) {
		return _db()->select($options['fields'])
			->from($options['table'])->where(@$options['conditions'])
			->filter(false)->groupBy(false)->orderBy(pzk_or($options['orderBy'], 'createdTime DESC'))
			->limit($options['pagination'], $options['page'])->result();
	}
}
?>