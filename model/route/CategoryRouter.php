<?php
class CategoryRouterModel {
	public function getAlias($table, $data, $alias, $aliasValue) {
		$parentCat = false;
		if (@$data['parentId']) {
			$parentCat = db_select('Category', $data['parentId']);
		}
		
		if (@$data['categoryId']) {
			$parentCat = db_select('Category', $data['categoryId']);
		}
		
		if ($parentCat) {
			$aliasValue = $parentCat['alias'] . '/' . vietdecode($aliasValue);
		}
		
		return $aliasValue;
	}
}
?>