<?php
class PzkEntityEduPaymentModel extends PzkEntityModel {
	public function getStatus($student) {
		$paids = $this->getPaids();
		if(isset($paids[$student->getId()])) { 
			$status = '<span style="color: green;">Đã thanh toán</span>'; 
			$this->setNumberOfPaids(1 + $this->getNumberOfPaids());
		} else { 
			$status = '<span style="color: red;">Chưa thanh toán</span>'; 
			$this->setNumberOfNonPaids(1 + $this->getNumberOfNonPaids());
		}
		return $status;
	}
	
	public function getAmount($student) {
		$paids = $this->getPaids();
		if(isset($paids[$student->getId()])) { 
			return product_price($paids[$student->getId()]['amount']);
		} else {
			return '0đ';
		}
	}

        public function getCreated($student) {
		$paids = $this->getPaids();
		if(isset($paids[$student->getId()])) { 
			return date('d/m/Y', strtotime($paids[$student->getId()]['created']));
		} else {
			return '';
		}
	}
	
	public function getRawAmount($student) {
		$paids = $this->getPaids();
		if(isset($paids[$student->getId()])) { 
			return $paids[$student->getId()]['amount'];
		} else {
			return 0;
		}
	}
	
	public function isPaid($student) {
		$paids = $this->getPaids();
		if(isset($paids[$student->getId()])) {
			return true;
		}
		return false;
	}
}