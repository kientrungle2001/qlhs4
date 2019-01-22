<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityTestTestTableModel extends PzkEntityModel {
	public $table = 'testtable';
	public function getTestTable2() {
		return $this->getRelateds('testtable2', 'test.testtable2', 'parentId');
	}
}
