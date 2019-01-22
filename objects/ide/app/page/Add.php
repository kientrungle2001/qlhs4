<?php
class PzkIdeAppPageAdd extends PzkObject {
	public $parentId = false;
	public $layout = 'ide/app/page/add';
	public function getBasedPages() {
		return _db()->select('id,title')->from('profile_resource')->where("parentId=$this->parentId and (type='BasedPage' or subType='BasedPage')")->result();
	}
}