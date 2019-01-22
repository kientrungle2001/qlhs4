<?php
class PzkDemoController extends PzkController {
	public $masterPage="demo";
	public $masterPosition = "left";
	public function indexAction() {
	}
	
	public function musterAction() {
		$this->renderOperation_muster();
	}
	
	public function musterTabAction() {
		$musterTab = $this->parseOperation_musterTab();
		$musterTab->setClassId(pzk_request()->getClassId());
		$class = $musterTab->getClass();
		if($class->isVMT()) {
			$musterTab->setLayout('edu/muster/vmt');
		} else {
			$musterTab->setLayout('edu/muster/normal');
		}
		$musterTab->display();
	}
	
	public function musterPrintAction() {
		$musterTab = $this->parseOperation_musterTab();
		$musterTab->setClassId(pzk_request()->getClassId());
		$class = $musterTab->getClass();
		if($class->isVMT()) {
			$musterTab->setLayout('edu/muster/print/vmt');
		} else {
			$musterTab->setLayout('edu/muster/print/normal');
		}
		$musterTab->display();
	}
	
	public function paymentstatAction() {
		$this->renderOperation_paymentstat();
	}
	
	public function orderstatAction() {
		$this->renderOperation_orderstat();
	}
	
	public function orderstatTabAction() {
		$orderstatTab = $this->parseOperation_orderstatTab();
		$orderstatTab->setClassId(pzk_request()->getClassId());
		$class = $orderstatTab->getClass();
		if($class->isVMT()) {
			$orderstatTab->setLayout('edu/orderstat/vmt');
		} else {
			$orderstatTab->setLayout('edu/orderstat/normal');
		}
		$orderstatTab->display();
	}
	
	public function paymentstatTabAction() {
		$paymentstatTab = $this->parseOperation_paymentstatTab();
		$paymentstatTab->setClassId(pzk_request()->getClassId());
		$class = $paymentstatTab->getClass();
		if($class->isVMT()) {
			$paymentstatTab->setLayout('edu/paymentstat/vmt');
		} else {
			$paymentstatTab->setLayout('edu/paymentstat/normal');
		}
		$paymentstatTab->display();
	}
	
	public function paymentstatPrintAction() {
		$paymentstatTab = $this->parseOperation_paymentstatTab();
		$paymentstatTab->setClassId(pzk_request()->getClassId());
		$class = $paymentstatTab->getClass();
		if($class->isVMT()) {
			$paymentstatTab->setLayout('edu/paymentstat/print/vmt');
		} else {
			$paymentstatTab->setLayout('edu/paymentstat/print/normal');
		}
		$paymentstatTab->display();
	}
	
	public function orderstatPrintAction() {
		$orderstatTab = $this->parseOperation_orderstatTab();
		$orderstatTab->setClassId(pzk_request()->getClassId());
		
		$class = $orderstatTab->getClass();
		if($class->isVMT()) {
			$orderstatTab->setLayout('edu/orderstat/print/vmt');
		} else {
			$orderstatTab->setLayout('edu/orderstat/print/normal');
		}
		$orderstatTab->display();
	}
	
	public function loginAction() {
		$this->parseLogin()->display();
	}
	
	public function loginPostAction() {
		$permission = pzk_element()->getPermission();
		
		if($permission->login(pzk_request()->getUsername(), pzk_request()->getPassword())) {
			$this->redirect('student/index');
		} else {
			$this->redirect('demo/login');
		}
	}
	
	public function logoutAction() {
		pzk_session()->setLoginId(false);
		$this->redirect('demo/login');
	}
	
	public function reportAction() {
		$this->renderOperation_report();
	}
	
	public function reportPostAction() {
		if(pzk_request()->getPassword() != 'abc123') die('Bạn không có quyền xem báo cáo này');
		$reportType = pzk_request()->getReportType();
		$this->initPage();
		$report = $this->parseOperation_report();
		$this->append($report);
		$reportResult = $this->parse('report/' . $reportType);
		foreach(array('reportType', 'teacherId', 'subjectId', 'classId', 'periodId') as $key) {
			$reportResult->$key = pzk_request($key);
			$elem = $report->findElement("[name=$key]");
			if($elem) {
				$elem->setValue(pzk_request($key));
			}
		}
		$this->append($reportResult);
		$this->display();
	}
	public function studentAction() {
		$this->redirect('student/index');
	}

	public function helloAction() {
		echo json_encode([
			"msg" => "Hello"
		]);
	}
}
