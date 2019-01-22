<?php
class PzkCoreRewriteTable extends PzkObjectLightweight{
	public $table = 'catalog_category';
	public $field = 'alias';
	public $routeField = 'code';
	public $action = '';
	public static $matched = false;
	public function init() {
		if(self::$matched) return true;
		$request = pzk_element('request');
		$route = preg_replace('/^[\/]/', '', $request->route);
		if($route) {
			$item = _db()->useCB()->select('*')->from($this->table)->where(array($this->field, $route))->result_one();
			
			if($item) {
				self::$matched = true;
				if($this->table == 'catalog_category') {
					if($item['parentId'] == 3) {
						if(1 && strpos($item['title'], 'Thiết kế phong thủy') === false) {
							$item['title'] = 'Thiết kế phong thủy <br />' . $item['title'];
							$item['alias'] = 'thiet-ke-phong-thuy-' . $item['alias'];
							if(1) {
								_db()->useCB()->update('catalog_category')->set(array(
									'title' => $item['title'],
									'alias' => $item['alias']
								))->where(array('id', $item['id']))->result();
							}
						}
						
					}
				}
				if($this->table == 'news_article') {
					if(strpos($item['categories'], '30') !== false 
					|| strpos($item['categories'], '31') !== false
					|| strpos($item['categories'], '32') !== false
					|| strpos($item['categories'], '33') !== false
					|| strpos($item['categories'], '34') !== false
					|| strpos($item['categories'], '35') !== false
					) {
						if(1 && strpos($item['title'], 'Thiết kế phong thủy') === false) {
							$item['title'] = 'Thiết kế phong thủy <br />' . $item['title'];
							$item['alias'] = 'thiet-ke-phong-thuy-' . $item['alias'];
							if(1) {
								_db()->useCB()->update('news_article')->set(array(
									'title' => $item['title'],
									'alias' => $item['alias']
								))->where(array('id', $item['id']))->result();
							}
						}
						
					}
				}
				$request->routeTable = $this->table;
				$request->routeData = $item;
				if($this->routeField && $item[$this->routeField]) {
					$request->route = '/' .$item[$this->routeField] . '/' . $item['id'];
				} else if($this->action)
					$request->route = '/' .$this->action . '/' . $item['id'];
			}
		}
	}
}