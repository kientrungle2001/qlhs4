<?php
require_once 'OrderCreate.php';
class PzkEcomOrderCreateSoftware extends PzkEcomOrderCreate {
	public function getSubjects() {
		return _db()->select('*')->from('subject')->whereOnline(1)->result();
	}
	public function getClasses() {
		return _db()->select('*')->from('classes')->whereOnline(1)->result();
	}
	public function getTeachers() {
		return _db()->select('*')->from('teacher')->result();
	}
}
