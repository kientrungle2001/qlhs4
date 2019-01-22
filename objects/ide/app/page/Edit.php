<?php
pzk_loader()->importObject('ide/form/Edit');
class PzkIdeAppPageEdit extends PzkIdeFormEdit {
	public $layout = 'ide/app/page/edit';
	public $app = false;
	public function getCurrentTemplate() {
		$app = $this->getApplication();
		if(isset($app['templateId'])) {
			return _db()->select('*')->from('resource')->where('id=' . $app['templateId'])->result_one();
		}
		return NULL;
	}
	
	public function getApplication() {
		if($this->app) return $this->app;
		$page = $this->getItem();
		$app = _db()->select('*')->from('profile_resource')->where('id='.$page['parentId'])->result_one();
		$this->app = $app;
		return $this->app;
	}
	
	public function getBasedPages() {
		$app = $this->getApplication();
		return _db()->select('id,title')->from('profile_resource')->where("parentId={$app['id']} and (type='BasedPage' or subType='BasedPage')")->result();
	}
}
