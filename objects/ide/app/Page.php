<?php
pzk_element('loader')->importObject('Page');
class PzkIdeAppPage extends PzkPage {
	public $item;
	public $app;
	public function displayRegion($region) {
		$conds = 'parentId=' . $this->item['id'] . 
				(@$this->item['basePageId'] ? ' or parentId=' . @$this->item['basePageId'] : '') ;
		$conds = "($conds) and `type`='Region' and `region`='$region'";
		$elements = _db()->select('*')->from('profile_resource')->where($conds)->orderBy('orderNum asc')->result();
		$this->_displayElements($elements);
	}
	
	public function _getProfileResources($parentId, $type) {
		if(!$parentId) return NULL;
		$items = _db()->select('*')->from('profile_resource')
			->where('parentId=' . $parentId . ' and (`type`=\'' . $type . '\' or subType=\'' . $type . '\')')
			->result();
		return $items;
	}
	
	public function _displayElements($elements, $region = false) {
		if(!$elements) return ;
		foreach($elements as $element) {
			if($region) {
				if(@$element['region'] != $region) {
					continue;
				}
			}
			if(@$element['eType']) {
				$elementType = $element['eType'];
			} else {
				$elementType = $element['subType'];
			}
			$frontElement = pzk_parse('<ide.app.page.region.front.' . $elementType . ' />');
			$frontElement->item = $element;
			$frontElement->display();
		}
	}
}