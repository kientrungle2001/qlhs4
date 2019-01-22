<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkStudentController extends PzkBaseController {
	public $grid = 'student';
	
	public function onlineAction() {
		$this->viewGrid('student/online');
	}
	
	public function centerAction() {
		$this->viewGrid('student/center');
	}
	
	public function classedAction() {
		$this->viewGrid('student/classed');
	}

	public function unclassedAction() {
		$this->viewGrid('student/unclassed');
	}

	public function ontestAction() {
		$this->viewGrid('student/ontest');
	}
	
	public function potentialAction() {
		$this->viewGrid('student/potential');
	}

	public function usedAction() {
		$this->viewGrid('student/used');
	}
	
	public function familiarAction() {
		$this->viewGrid('student/familiar');
	}

	public function loginAction() {
		$page = pzk_parse($this->getApp()->getPageUri('login'));
		pzk_element('loginForm')->action = BASE_REQUEST . '/student/loginPost';
		$page->display();
	}
	
	public function loginPostAction() {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$permission = pzk_element('permission');
		
		if($permission->studentLogin($username, $password)) {
			header('Location: '. BASE_REQUEST . '/student/info');
		} else {
			header('Location: '. BASE_REQUEST . '/student/login');
		}
	}
	
	public function infoAction() {
		$this->viewOperation('info');
	}
	
	public function orderAction() {
		$this->viewGrid('student_order');
	}
	
	public function searchAction() {
		$this->viewOperation('student_search');
	}
	
	public function searchresultAction() {
		$student_list = $this->getOperationStructure('student_list');
		$student_list->name = @$_REQUEST['name'];
		$student_list->phone = @$_REQUEST['phone'];
		$student_list->classId = @$_REQUEST['classId'];
		$student_list->payment = @$_REQUEST['payment'];
		$student_list->payment_period = @$_REQUEST['payment_period'];
		$student_list->display();
	}
	
	public function detailAction() {
		$this->masterStructure = 'ajax';
		$this->masterPosition = 'ajax';
		$student_detail = $this->getOperationStructure('student_detail');
		$student_detail->studentId = @$_REQUEST['id'];
		$this->render($student_detail);
	}
}