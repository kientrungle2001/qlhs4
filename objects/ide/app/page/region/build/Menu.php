<?php
class PzkIdeAppPageRegionBuildMenu extends PzkObject {
	public $layout = 'ide/app/page/region/build/menu';
	public function getPages() {
		$region = pzk_element('build')->getItem();
		$app = _db()->getParent('profile_resource', $region['id'], "type='Application'");
		return _db()->getChildren('profile_resource', $app['id'], 'type="Page"');
	}
}