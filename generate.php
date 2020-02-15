<?php
function rcopy($source, $target) {
	if(file_exists($target))
					copy($target, $source);
}
function generate_controller($controller, $force = false) {
	if(!$force && file_exists(PKG_DIR . DS . "controller.$controller.php")) {
		echo "Controller $controller Existed\r\n";
		return false;
	}
	$tmpl = file_get_contents(PKGS_DIR . DS . 'tmpl' . DS .'controller.tmpl');
	$content = str_replace('{controller}', $controller, $tmpl);
	file_put_contents(PKG_DIR . DS . "controller.$controller.php", $content);
}
define ('BASE_DIR', dirname(__FILE__));
define('PKGS_DIR', BASE_DIR . '/packages');
define('DS', DIRECTORY_SEPARATOR);
$package = isset($argv[1]) ? $argv[1]: null;
$type = isset($argv[2]) ? $argv[2]: 'controller';

if(null === $package) {
	echo "You should enter the package name!\r\n";
} else {
	if(!is_dir(PKGS_DIR . DS . $package)) {
		echo "package [$package] does not exist! \r\n";
	} else {
		define ('PKG_DIR', PKGS_DIR . DS . $package);
		if($type === 'controller') {
			$controller = isset($argv[3]) ? $argv[3]: $package;
			$controller = ucfirst($controller);
			$force = isset($argv[4]) ? $argv[4]: false;
			if($force === '-f') $force = true;
			generate_controller($controller, $force);
		}
	}
}