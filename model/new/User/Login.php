<?php
class UserLoginObject extends FunctionObject {
	public function call(&$user, $arguments) {
		$user->lastLoginId = $arguments['username'];
		pre($user);
		pre($user->validate());
	}
}
?>