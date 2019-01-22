<?php
pzk_element('loader')->importObject('ide/form/Edit');
class PzkIdeAppEdit extends PzkIdeFormEdit {
	public $layout = 'ide/app/edit';
	public function getTemplates() {
		return _db()->select('*')->from('resource')->where("type='Template' or subType='Template'")->result();
	}
	
	public function getCurrentTemplate() {
		$app = $this->getItem();
		if(isset($app['templateId'])) {
			return _db()->select('*')->from('resource')->where('id=' . $app['templateId'])->result_one();
		}
		return NULL;
	}
}