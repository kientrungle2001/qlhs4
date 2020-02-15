<?php
echo "Location\r\n";
// create controller
copy(PKG_DIR . DS . 'controller.Location.php', BASE_DIR . '/app/qlhs/controller/Location.php');
// create grid
copy(PKG_DIR . DS . 'page.location.php', BASE_DIR . '/app/qlhs/pages/grid/location.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/location')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/location');
}
//	create billing
copy(PKG_DIR . DS . 'page.location.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/location/datagrid.php');