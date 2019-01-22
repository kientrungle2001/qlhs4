<?php
class PzkCoreControllerRoute extends PzkObjectLightWeight {
	public $loaded = false;
	public $route = false;
	
	public function init() {
		$this->loadData();
	}
	
	public function loadData() {
		if (!$this->loaded) {
			require_once BASE_DIR . '/lib/string.php';
			if (@$_REQUEST['route']) {
				$route = $this->route = $_REQUEST['route'];
				$segments = explode('/', $route);
				$_REQUEST['controller'] = pzk_or(@$_REQUEST['controller'], @$segments[1], 'Home');
				$_REQUEST['action'] = pzk_or(@$_REQUEST['action'], @$segments[2], 'index');
				if (!REQUEST_MODE)
					$_REQUEST['arguments'] = array_splice($segments, 3);
			}
			$this->loaded = true;
		}
	}

	public function redirect($alias) {
		header('Location: ' . _app_url($alias));
	}

	public function url($alias) {
		return BASE_URL . '/index.php/' . $alias;
	}

	public function lastUrl($url = NULL) {
		return _session('lastUrl', $url);
	}

	public function get($key) {
		return @$this->route[$key];
	}
}
?>