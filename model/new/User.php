<?php
class UserObject extends ObjectObject {
	public function validate() {
		if ($this->lastLoginId == 'Kien') return 1;
		return 0;
	}
}
?>