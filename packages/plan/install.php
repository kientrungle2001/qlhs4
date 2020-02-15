<?php
echo "Plan\r\n";
// create controller
copy(PKG_DIR . DS . 'controller.Plan.php', BASE_DIR . '/app/qlhs/controller/Plan.php');
// create grid
copy(PKG_DIR . DS . 'page.plan.php', BASE_DIR . '/app/qlhs/pages/grid/plan.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/plan')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/plan');
}
//	create billing
copy(PKG_DIR . DS . 'page.plan.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/plan/datagrid.php');
copy(PKG_DIR . DS . 'page.plan.task.php', BASE_DIR . '/app/qlhs/pages/grid/plan/task.php');