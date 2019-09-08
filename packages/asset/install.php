<?php
echo "Assets\r\n";
copy(PKG_DIR . DS . 'controller.Asset.php', BASE_DIR . '/app/qlhs/controller/Asset.php');
copy(PKG_DIR . DS . 'page.asset.php', BASE_DIR . '/app/qlhs/pages/grid/asset.php');
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/asset')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/asset');
}
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/asset/schedule')) {
	mkdir(BASE_DIR . '/app/qlhs/pages/grid/asset/schedule');
}
copy(PKG_DIR . DS . 'page.asset.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/asset/datagrid.php');
copy(PKG_DIR . DS . 'page.asset.facility.php', BASE_DIR . '/app/qlhs/pages/grid/asset/facility.php');
copy(PKG_DIR . DS . 'page.asset.online.php', BASE_DIR . '/app/qlhs/pages/grid/asset/online.php');
copy(PKG_DIR . DS . 'page.asset.document.php', BASE_DIR . '/app/qlhs/pages/grid/asset/document.php');
copy(PKG_DIR . DS . 'page.asset.schedule.php', BASE_DIR . '/app/qlhs/pages/grid/asset/schedule.php');
copy(PKG_DIR . DS . 'page.asset.schedule.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/asset/schedule/datagrid.php');
copy(PKG_DIR . DS . 'page.asset.schedule.teacher.php', BASE_DIR . '/app/qlhs/pages/grid/asset/schedule/teacher.php');