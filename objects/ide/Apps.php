<?php
class PzkIdeApps extends PzkObject {
	public $layout = 'ide/apps';
	public $profileId = false;
	public function getApps() {
		return _db()->select('*')->from('profile_resource')->where("(type='Application' or subType='Application') and profileId=" . $this->profileId)->result();
	}
	
	public function getTemplates() {
		return _db()->select('*')->from('resource')->where("type='Template' or subType='Template'")->result();
	}
	
	public function getApplications() {
		return _db()->select('*')->from('resource')->where("type='Application' or subType='Application'")->result();
	}
}