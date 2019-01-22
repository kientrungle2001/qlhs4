<?php
class PzkCoreRegion extends PzkObjectLightWeight {
	public function getElements($page, $region) {
		$tmp = explode('.', $page);
		$controller = $tmp[0];
		$items = _db()->select('*')->from('region')
			->where("(page='' or page='$controller' or page='$page') and region='$region'")
			->orderBy('ordering asc, page asc, id asc')
			->result();
		return $items;
	}
	
	public function displayElements($page, $region) {
		$elements = $this->getElements($page, $region);
		$this->_displayElements($elements);
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
				$elementType = $element['type'];
			}
			$frontElement = pzk_parse('<ide.app.page.region.front.' . $elementType . ' />');
			$frontElement->item = $element;
			$frontElement->display();
		}
	}
	
	public function pageElements($region) {
		$request = pzk_element('request');
		$controller = $request->get('controller');
		$action = $request->get('action');
		$page = $controller . '.' . $action;
		return $this->displayElements($page, $region);
	}
	
	public function pageappElements($region) {
		$request = pzk_element('request');
		$appId = $request->get('appId');
		$pageId = $request->get('pageId');
		$elements = $this->getProfileResources($pageId, 'Region');
		$commonPages = $this->getProfileResources($appId, 'CommonPage');
		if(count($commonPages)) {
			$commonPage = $commonPages[0];
			$commonElements = $this->getProfileResources($commonPage['id'], 'Region');
			if($pageId != $commonPage['id'])
				$this->_displayElements($commonElements, $region);
		}
		$this->_displayElements($elements, $region);
	}
	
	public function getProfileResources($parentId, $type) {
		if(!$parentId) return NULL;
		$items = _db()->select('*')->from('profile_resource')->where('parentId=' . $parentId . ' and (`type`=\'' . $type . '\' or subType=\'' . $type . '\')')->result();
		return $items;
	}
}