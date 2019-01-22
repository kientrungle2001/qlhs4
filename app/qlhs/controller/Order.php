<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkOrderController extends PzkBaseController {
	public $grid = 'student_order';
	public $masterPage = 'demo';
	public $masterPosition = 'left';
	public function createAction() {
		$create_order = $this->getOperationStructure('create_order');
		$create_order->setStudentId(pzk_request()->getStudentId());
		$create_order->setPeriodId(pzk_request()->getPeriodId());
		if(pzk_request()->getMultiple()) {
			$create_order->setMultiple(true);
			$create_order->setClassIds(pzk_request()->getClassIds());
			$create_order->setAmounts(pzk_request()->getAmounts());
			$create_order->setDiscounts(pzk_request()->getDiscounts());
			$create_order->setMusters(pzk_request()->getMusters());
			$create_order->setPrices(pzk_request()->getPrices());
			$create_order->setDiscount_reasons(pzk_request()->getDiscount_reasons());
		} else {
			$create_order->setMultiple(false);
			$create_order->setClassId(pzk_request()->getClassId());;
			$create_order->setAmount(pzk_request()->getAmount());
		}
		$this->viewStructure($create_order);
	}
	
	public function detailAction() {
		$order_detail = $this->getOperationStructure('order_detail');
		$order_detail->setOrderId(pzk_request()->getId());
		$xcssjs = '<html.js src="' . BASE_URL . '/xcss" />';
		$xcsscss = '<html.css src="' . BASE_URL . '/xcss/output/test.css" />';
		$order_detail->append(pzk_parse($xcssjs));
		$order_detail->append(pzk_parse($xcsscss));
		$order_detail->display();
	}
	
	public function billingdetailAction() {
		$order = _db()->getTableEntity('billing_order');
		$order->load(pzk_request()->getId());
		if($order->getType() == 'normal') {
			$order_detail = $this->getOperationStructure('bill_detail2');
			$order_detail->setOrderId(pzk_request()->getId());
			$xcssjs = '<html.js src="' . BASE_URL . '/xcss" />';
			$xcsscss = '<html.css src="' . BASE_URL . '/xcss/output/test.css" />';
			$order_detail->append(pzk_parse($xcssjs));
			$order_detail->append(pzk_parse($xcsscss));
			$order_detail->display();	

		} else {
			$order_detail = $this->getOperationStructure('bill_detail');
			$order_detail->setOrderId(pzk_request()->getId());
			$xcssjs = '<html.js src="' . BASE_URL . '/xcss" />';
			$xcsscss = '<html.css src="' . BASE_URL . '/xcss/output/test.css" />';
			$order_detail->append(pzk_parse($xcssjs));
			$order_detail->append(pzk_parse($xcsscss));
			$order_detail->display();	
		}
		
	}
	
	public function postAction() {
		if(@$_REQUEST['bookNum'] && @$_REQUEST['noNum']) {
			// do nothing
			$bookNum = $_REQUEST['bookNum'];
			$noNum = $_REQUEST['noNum'];
		} else {
			$bookNum = pzk_element('config')->get('bookNum', 1);
			$noNum = pzk_element('config')->get('noNum', 1);
		}
		$order = array(
			'orderType' => 'invoice',
			'type' => 'student',
			'amount' => $_REQUEST['amount'],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $bookNum,
			'noNum' => $noNum,
			'debit' => $_REQUEST['debit'],
			'name' => $_REQUEST['name'],
			'phone' => $_REQUEST['phone'],
			'address' => $_REQUEST['address'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum'],
			'studentId'	=>	$_REQUEST['studentId']
		);
		$orderId = _db()->insert('general_order')
				->fields(implode(',', array_keys($order)))
				->values(array($order))->result();
		$classIds = explode(',', $_REQUEST['classIds']);
		$amounts = explode(',', $_REQUEST['amounts']);
		$discounts = explode(',', $_REQUEST['discounts']);
		$musters = explode(',', $_REQUEST['musters']);
		$prices = explode(',', $_REQUEST['prices']);
		$discount_reasons = explode(',', $_REQUEST['discount_reasons']);
		foreach($classIds as $index => $classId) {
		$student_order = array(
			'orderId' => $orderId,
			'classId' => $classId,
			'studentId' => $_REQUEST['studentId'],
			'payment_periodId' => $_REQUEST['payment_periodId'],
			'amount' => $amounts[$index],
			'discount' => $discounts[$index],
			'discount_reason' => $discount_reasons[$index],
			'muster' => $musters[$index],
			'price' => $prices[$index],
			'total_before_discount' => $musters[$index] * $prices[$index],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $bookNum,
			'noNum' => $noNum,
			'debit' => $_REQUEST['debit'],
			'name' => $_REQUEST['name'],
			'address' => $_REQUEST['address'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		_db()->insert('student_order')->fields(implode(',',array_keys($student_order)))
			->values(array($student_order))->result();
		$student = _db()->getEntity('edu.student')->load($student_order['studentId']);
			if($student->getId()) {
				$student->gridIndex();
			}
		}
		if(@$_REQUEST['bookNum'] && @$_REQUEST['noNum']) { 
			// do nothing
		} else {
			if($noNum >= 50) {
				pzk_element('config')->set('noNum', 1);
				pzk_element('config')->set('bookNum', $bookNum + 1);
			} else {
				pzk_element('config')->set('noNum', $noNum + 1);
				pzk_element('config')->set('bookNum', $bookNum);
			}
		}
		header('Location: '.BASE_URL.'/index.php/student/order');
	}
	
	public function billingAction() {
		$this->viewGrid('order_billing');
	}
	
	public function createbillAction() {
		$this->viewOperation('create_bill');
		//$create_order->display();
	}
	public function createordermanualAction() {
		$this->viewOperation('create_order_manual');
		//$create_order->display();
	}
	public function createbill2Action() {
		$this->viewOperation('create_bill2');
		//$create_order->display();
	}
	public function createbillpostAction() {
		$bookNum = $_REQUEST['bookNum'] = pzk_element('config')->get('bill_bookNum', 1);
		$noNum = $_REQUEST['noNum'] = pzk_element('config')->get('bill_noNum', 1);
		$order = array(
			'orderType' => 'billing',
			'type' => '',
			'amount' => $_REQUEST['total_amount'],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $_REQUEST['bookNum'],
			'noNum' => $_REQUEST['noNum'],
			'debit' => $_REQUEST['debit'],
			'name' => $_REQUEST['order_name'],
			'address' => $_REQUEST['address'],
			'phone' => $_REQUEST['phone'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		$orderId = _db()->insert('billing_order')
				->fields(implode(',', array_keys($order)))
				->values(array($order))->result();
		$names = $_REQUEST['name'];
		$amounts = $_REQUEST['amount'];
		$total_before_discounts = $_REQUEST['total_before_discount'];
		$discounts = $_REQUEST['discount'];
		$prices = $_REQUEST['price'];
		$quantitys = $_REQUEST['quantity'];
		foreach($names as $index => $name) {
		$order_item = array(
			'orderId' => $orderId,
			'amount' => $amounts[$index],
			'discount' => $discounts[$index],
			'quantity' => $quantitys[$index],
			'price' => $prices[$index],
			'total_before_discount' => $total_before_discounts[$index],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $_REQUEST['bookNum'],
			'noNum' => $_REQUEST['noNum'],
			'debit' => $_REQUEST['debit'],
			'name' => $names[$index],
			'address' => $_REQUEST['address'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		_db()->insert('billing_detail_order')->fields(implode(',',array_keys($order_item)))
			->values(array($order_item))->result();
		}
		if($noNum >= 50) {
			pzk_element('config')->set('bill_noNum', 1);
			pzk_element('config')->set('bill_bookNum', $bookNum + 1);
		} else {
			pzk_element('config')->set('bill_noNum', $noNum + 1);
			pzk_element('config')->set('bill_bookNum', $bookNum);
		}
		header('Location: '.BASE_URL.'/index.php/order/billing');
	}
	
	public function createbillpost2Action() {
		$bookNum = $_REQUEST['bookNum'] = pzk_element('config')->get('bill_bookNum', 1);
		$noNum = $_REQUEST['noNum'] = pzk_element('config')->get('bill_noNum', 1);
		$order = array(
			'orderType' => 'billing',
			'type' => 'normal',
			'amount' => $_REQUEST['total_amount'],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $_REQUEST['bookNum'],
			'noNum' => $_REQUEST['noNum'],
			'debit' => $_REQUEST['debit'],
			'name' => $_REQUEST['order_name'],
			'address' => $_REQUEST['address'],
			'phone' => $_REQUEST['phone'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		$orderId = _db()->insert('billing_order')
				->fields(implode(',', array_keys($order)))
				->values(array($order))->result();
		
		$order_item = array(
			'orderId' => $orderId,
			'amount' => $_REQUEST['total_amount'],
			'discount' => 0,
			'quantity' => 1,
			'price' => $_REQUEST['total_amount'],
			'total_before_discount' => $_REQUEST['total_amount'],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $_REQUEST['bookNum'],
			'noNum' => $_REQUEST['noNum'],
			'debit' => $_REQUEST['debit'],
			'name' => $_REQUEST['order_name'],
			'address' => $_REQUEST['address'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		_db()->insert('billing_detail_order')->fields(implode(',',array_keys($order_item)))
			->values(array($order_item))->result();
		
		if($noNum >= 50) {
			pzk_element('config')->set('bill_noNum', 1);
			pzk_element('config')->set('bill_bookNum', $bookNum + 1);
		} else {
			pzk_element('config')->set('bill_noNum', $noNum + 1);
			pzk_element('config')->set('bill_bookNum', $bookNum);
		}
		header('Location: '.BASE_URL.'/index.php/order/billing');
	}
	
	public function createordermanualpostAction() {
		$bookNum = $_REQUEST['bookNum'] = pzk_element('config')->get('bill_bookNum', 1);
		$noNum = $_REQUEST['noNum'] = pzk_element('config')->get('bill_noNum', 1);
		$order = array(
			'orderType' => 'invoice',
			'type' => '',
			'amount' => $_REQUEST['total_amount'],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $_REQUEST['bookNum'],
			'noNum' => $_REQUEST['noNum'],
			'debit' => $_REQUEST['debit'],
			'name' => $_REQUEST['order_name'],
			'address' => $_REQUEST['address'],
			'phone' => $_REQUEST['phone'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		$orderId = _db()->insert('billing_order')
				->fields(implode(',', array_keys($order)))
				->values(array($order))->result();
		$names = $_REQUEST['name'];
		$amounts = $_REQUEST['amount'];
		$total_before_discounts = $_REQUEST['total_before_discount'];
		$discounts = $_REQUEST['discount'];
		$prices = $_REQUEST['price'];
		$quantitys = $_REQUEST['quantity'];
		foreach($names as $index => $name) {
		$order_item = array(
			'orderId' => $orderId,
			'amount' => $amounts[$index],
			'discount' => $discounts[$index],
			'quantity' => $quantitys[$index],
			'price' => $prices[$index],
			'total_before_discount' => $total_before_discounts[$index],
			'created' => date('Y-m-d', strtotime($_REQUEST['created'])),
			'createdTime' => time(),
			'bookNum' => $_REQUEST['bookNum'],
			'noNum' => $_REQUEST['noNum'],
			'debit' => $_REQUEST['debit'],
			'name' => $names[$index],
			'address' => $_REQUEST['address'],
			'reason' => $_REQUEST['reason'],
			'additional' => $_REQUEST['additional'],
			'invoiceNum' => $_REQUEST['invoiceNum']
		);
		_db()->insert('billing_detail_order')->fields(implode(',',array_keys($order_item)))
			->values(array($order_item))->result();
		}
		if($noNum >= 50) {
			pzk_element('config')->set('bill_noNum', 1);
			pzk_element('config')->set('bill_bookNum', $bookNum + 1);
		} else {
			pzk_element('config')->set('bill_noNum', $noNum + 1);
			pzk_element('config')->set('bill_bookNum', $bookNum);
		}
		header('Location: '.BASE_URL.'/index.php/order/billing');
	}
	
	public function reportAction() {
		$this->render('operation/order_report');
	}
	
	public function reportPostAction() {
		$reportType = 'order';
		$this->initPage();
		$report = $this->parse('operation/order_report');
		$this->append($report);
		$reportResult = $this->parse('report/' . $reportType);
		
		foreach(array('startDate', 'endDate', 'subject', 'notsubject') as $key) {
			$reportResult->$key = @$_REQUEST[$key];
			$elem = $report->findElement("[name=$key]");
			if($elem) {
				$elem->value = @$_REQUEST[$key];
			}
		}
		$this->append($reportResult);
		$this->display();
	}

	public function createteacherbillingAction() {
		
	}

	public function createpartnerbillingAction() {
		
	}
}