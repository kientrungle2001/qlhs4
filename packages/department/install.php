<?php
echo "Department\r\n";
copy(PKG_DIR . DS . 'controller.Department.php', BASE_DIR . '/app/qlhs/controller/Department.php');
copy(PKG_DIR . DS . 'page.department.php', BASE_DIR . '/app/qlhs/pages/grid/department.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/department')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/department');
}
copy(PKG_DIR . DS . 'page.department.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/department/datagrid.php');
copy(PKG_DIR . DS . 'page.department.teacher.php', BASE_DIR . '/app/qlhs/pages/grid/department/teacher.php');