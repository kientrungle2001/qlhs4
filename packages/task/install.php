<?php
echo "Task\r\n";
// create controller
copy(PKG_DIR . DS . 'controller.Task.php', BASE_DIR . '/app/qlhs/controller/Task.php');
// create grid
copy(PKG_DIR . DS . 'page.task.php', BASE_DIR . '/app/qlhs/pages/grid/task.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/task')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/task');
}
//	create billing
copy(PKG_DIR . DS . 'page.task.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/task/datagrid.php');