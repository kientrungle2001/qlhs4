<?php

class PzkCoreApplication extends PzkObjectLightWeight {

	/**
	 * Tên ứng dụng
	 * @var string
	 */
    public $name = false;
    public $libraries = array();
    public $controller = false;
	
    /**
     * Chạy controller
     */
	public function run() {
		$request = pzk_element('request');
		$controller = pzk_or(@$request->query['controller'], 'Home');
		$action = pzk_or(@$request->query['action'], 'index');
		$controllerObject = $this->_getController($controller);
		if(!$controllerObject) die('No controller ' .$controller);
		$controllerObject->setApp($this);
		$this->controller = $controllerObject;
		if(method_exists($controllerObject, $action . 'Action'))
			$controllerObject->{$action . 'Action'}();
		else {
			die('No route ' . $action);
		}
	}
	
	/**
	 * Trả về instance của controller
	 * @param string $controller tên controller, dạng user, hoặc admin_user
	 * @return PzkController
	 */
	private function _getController($controller) {
		$parts = explode('_', $controller);
		$parts[count($parts)-1] = str_ucfirst($parts[count($parts)-1]);
		$fileName = $this->getUri('controller/' . implode('/', $parts) . '.php');
		if(!file_exists($fileName)) {
			$fileName = 'controller/' . implode('/', $parts) . '.php';
			if(!file_exists($fileName)){
				echo 'File ' . $fileName . ' không tồn tại <br />';
				return null;
			}
		}
		require_once $fileName;
		$controllerClass = PzkParser::getClass( $parts ) . 'Controller';
		return new $controllerClass();
	}

	/**
	 * Trả về đường dẫn theo ứng dụng
	 * @param string $path đường dẫn, dạng application
	 * @return string đường dẫn trả về, dạng app/ptnn/application
	 */
    public function getUri($path) {
        return 'app/' . $this->name . '/' . $path;
    }

    /**
     * Trả về đường dẫn của page
     * @param string $page tên page, dạng index,user/info
     * @return string đường dẫn dạng app/ptnn/pages/index
     */
    public function getPageUri($page) {
		$page = preg_replace('/^\//', '', $page);
        return $this->getUri('pages/' . $page);
    }

}
/**
 * Return application element
 *
 * @return PzkCoreApplication
 */
function pzk_app() {
	return pzk_store_element('app');
}

/**
 * Trả về controller đang chạy
 * @return PzkController
 */
function pzk_controller() {
	return pzk_app()->controller;
}

/**
 * Trả về admin controller đang chạy
 * @return PzkAdminController
 */
function pzk_admin_controller() {
	return pzk_app()->controller;
}
/**
 * Trả về grid admin controller đang chạy
 * @return PzkGridAdminController
 */
function pzk_grid_admin_controller() {
	return pzk_app()->controller;
}
?>