<?php
echo "Category\r\n";
// create controller
copy(PKG_DIR . DS . 'controller.Category.php', BASE_DIR . '/app/qlhs/controller/Category.php');
// create grid
copy(PKG_DIR . DS . 'page.category.php', BASE_DIR . '/app/qlhs/pages/grid/category.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/category')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/category');
}
//	create billing
copy(PKG_DIR . DS . 'page.category.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/category/datagrid.php');