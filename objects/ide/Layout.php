<?php
class PzkIdeLayout extends PzkObject {
	public $templateId = false;
	public $pageId = false;
	public $regions = false;
	public $scriptable = true;
	public function getTemplate() {
		if(!$this->templateId) return NULL;
		$items = _db()->select('*')->from('resource')->where("(type='Template' or subType='Template') and id=" . $this->templateId)->result();
		if(count($items)) {
			return $items[0];
		}
		return NULL;
	}
	
	public function getPage() {
		if(!$this->pageId) return NULL;
		$items = _db()->select('*')->from('profile_resource')->where("(type='Page' or subType='Page') and id=" . $this->pageId)->result();
		if(count($items)) {
			return $items[0];
		}
		return NULL;
	}
	
	public function displayRegions($region) {
		$element = pzk_parse('<ide.layout.region />');
		$element->items = $this->getRegions($region);
		$element->region = $region;
		$element->pageId = $this->pageId;
		$element->display();
	}
	
	public function getRegions($region) {
		$regions = $this->getAllRegions();
		if(isset($regions[$region])) {
			return $regions[$region];
		} else {
			return array();
		}
	}
	
	public function getAllRegions() {
		if($this->regions == false) {
			$this->regions = array();
			$items = _db()->select('*')->from('profile_resource')->where("(type='Region' or subType='Region') and parentId=" . $this->pageId)->result();
			foreach($items as $item) {
				if(!isset($this->regions[$item['region']])) {
					$this->regions[$item['region']] = array();
				}
				$this->regions[$item['region']][] = $item;
			}
		}
		return $this->regions;
	}
}