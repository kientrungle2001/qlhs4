<?php
class PzkIdeApp extends PzkObject {
	public $layout = 'ide/app';
	public $appId = false;
	public $pageId = false;
	public $regionId = false;
	public function getApp() {
		$items = _db()->select('*')->from('profile_resource')->where("(type='Application' or subType='Application') and id=" . $this->appId)->result();
		if(count($items)) {
			return $items[0];
		}
		return NULL;
	}
	
	public function getTemplates() {
		return _db()->select('*')->from('resource')->where("type='Template' or subType='Template'")->result();
	}
	
	public function getPages() {
		return _db()->select('*')->from('profile_resource')->where("(type='Page' or subType='Page') and parentId=" . $this->appId)->result();
	}
	
	public function getPage() {
		if(!$this->pageId) return NULL;
		$items = _db()->select('*')->from('profile_resource')->where("(type='Page' or subType='Page') and id=" . $this->pageId)->result();
		if(count($items)) {
			return $items[0];
		}
		return NULL;
	}
	
	public function getRegions() {
		if(!$this->pageId) return NULL;
		return _db()->select('*')->from('profile_resource')->where("(type='Region' or subType='Region') and parentId=" . $this->pageId)->result();
	}
	
	public function getRegion() {
		if(!$this->regionId) return NULL;
		$items = _db()->select('*')->from('profile_resource')->where("(type='Region' or subType='Region') and id=" . $this->regionId)->result();
		if(count($items)) {
			return $items[0];
		}
		return NULL;
	}
}