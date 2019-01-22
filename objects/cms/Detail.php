<?php
pzk_import('core.db.Detail');
class PzkCmsDetail extends PzkCoreDbDetail {
	public $layout = 'cms/detail';
	public function getPlugins() {
		$rs = array();
		$plugins = _db()->from('plugin')->whereTable($this->getTable())->result();
		foreach($plugins as $plugin) {
			$pluginObj = _db()->getEntity('cms.plugin.' . $plugin['object']);
			$pluginObj->setData($plugin);
			$rs[] = $pluginObj;
		}
		return $rs;
	}
}
?>