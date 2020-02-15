<?php
echo "Problem\r\n";
// create controller
copy(PKG_DIR . DS . 'controller.Problem.php', BASE_DIR . '/app/qlhs/controller/Problem.php');
// create grid
copy(PKG_DIR . DS . 'page.problem.php', BASE_DIR . '/app/qlhs/pages/grid/problem.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/problem')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/problem');
}
//	create billing
copy(PKG_DIR . DS . 'page.problem.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/problem/datagrid.php');