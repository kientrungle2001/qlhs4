<?php
class PzkApplicationDispatcherControllerBased extends PzkApplicationDispatcher {
	public function run($app) {
		$controller = pzk_or(@$_REQUEST['controller'], 'Home');
		$action = pzk_or(@$_REQUEST['action'], 'index');
		$controllerObject = $this->_getController($app, $controller);
		$controllerObject->setApp($app);
		$controllerObject->{$action . 'Action'}();
	}
	
	public function _getController($app, $controller) {
		$parts = explode('_', $controller);
		require_once $app->getUri('controller/' . implode('/', $parts) . '.php');
		$controller = str_ucfirst(array_pop($parts));
		$controllerClass = 'Pzk' . $controller . 'Controller';
		return new $controllerClass();
	}
}
?>