<?php

require_once 'config.php';
require_once 'include.php';

$uri = PzkURI::instance();
$uri->dispatch();

ob_start();
$sys = _parse('system/controller');
$sys->display();
$content = ob_get_contents();
ob_end_clean();

echo $content;