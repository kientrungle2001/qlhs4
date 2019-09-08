<?php
echo "Center\r\n";
// create controller
copy(PKG_DIR . DS . 'controller.Center.php', BASE_DIR . '/app/qlhs/controller/Center.php');
// create grid
copy(PKG_DIR . DS . 'page.center.php', BASE_DIR . '/app/qlhs/pages/grid/center.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/center')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/center');
}
//	create billing
copy(PKG_DIR . DS . 'page.center.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/center/datagrid.php');
copy(PKG_DIR . DS . 'page.center.asset.php', BASE_DIR . '/app/qlhs/pages/grid/center/asset.php');
copy(PKG_DIR . DS . 'page.center.classes.php', BASE_DIR . '/app/qlhs/pages/grid/center/classes.php');
copy(PKG_DIR . DS . 'page.center.room.php', BASE_DIR . '/app/qlhs/pages/grid/center/room.php');
copy(PKG_DIR . DS . 'page.center.schedule.php', BASE_DIR . '/app/qlhs/pages/grid/center/schedule.php');
