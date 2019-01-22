<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkScheduleController extends PzkBaseController {
	public function dailyAction() {
		$schedule = $this->getOperationStructure('schedule/daily');
		#
		$currentDate = pzk_request()->getCurrentDate();
		if(!$currentDate) {
			$currentDate = date('Y-m-d');
		}
		$schedule->setCurrentDate($currentDate);
		#
		$this->render($schedule);
	}

	public function weeklyAction() {
		$schedule = $this->getOperationStructure('schedule/weekly');
		#
		$currentWeek = pzk_request()->getCurrentWeek();
		if(!$currentWeek) {
			$currentWeek = date('Y-W');
		}
		$schedule->setCurrentWeek($currentWeek);
		#
		$this->render($schedule);
	}

	public function teacherAction() {
		$schedule = $this->getOperationStructure('schedule/teacher');
		#
		if(pzk_request()->getIsAjax()) {
			$schedule->setIsAjax(true);
		} else {
			$schedule->setIsAjax(false);
		}
		#
		$teacherId = pzk_request()->getTeacherId();
		$schedule->setTeacherId($teacherId);
		#
		$currentWeek = pzk_request()->getCurrentWeek();
		if(!$currentWeek) {
			$currentWeek = date('Y-W');
		}
		$schedule->setCurrentWeek($currentWeek);
		#
		if(pzk_request()->getIsAjax()) {
			$schedule->display();
		} else {
			$this->render($schedule);
		}
		
	}

	public function classAction() {
		$schedule = $this->getOperationStructure('schedule/class');
		#
		$classId = pzk_request()->getClassId();
		$schedule->setClassId($classId);
		#
		$month = pzk_request()->getMonth();
		if(!$month) {
			$month = date('Y-m');
		}
		$schedule->setMonth($month);
		#
		$schedule->display();
	}

	public function subjectAction() {
		$schedule = $this->getOperationStructure('schedule/subject');
		#
		$subjectId = pzk_request()->getSubjectId();
		$schedule->setSubjectId($subjectId);
		#
		$week = pzk_request()->getWeek();
		if(!$week) {
			$week = date('Y-W');
		}
		$schedule->setWeek($week);
		#
		$schedule->display();
	}

	public function roomAction() {
		$schedule = $this->getOperationStructure('schedule/room');
		#
		$roomId = pzk_request()->getRoomId();
		$schedule->setRoomId($roomId);
		#
		$week = pzk_request()->getWeek();
		if(!$week) {
			$week = date('Y-W');
		}
		$schedule->setWeek($week);
		#
		$schedule->display();
	}

}