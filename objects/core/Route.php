<?php
class PzkCoreRoute extends PzkObject {
	public $table;
	public $model = 'Route';
	public $loaded = false;
	public $route = false;
	
	public function init() {
		parent::display();
	}
	
	public function display() {
		
	}
	
	public function loadData() {
		if (!$this->loaded) {
			if (@$_REQUEST['route']) {
				$this->route = $this->model->route(urldecode(@$_REQUEST['route']) );
				if (@$_REQUEST['showQuery']) pre('start route');
				if (@$this->route) {
					foreach($this->route as $key => $value) {
						$_REQUEST[$key] = $value;
					}
					$rq = array();
					parse_str($this->route['url'], $rq);
					foreach($rq as $key => $value) {
						$_REQUEST[$key] = $value;
					}
				} else {
					$uri = PzkURI::instance();
					$_REQUEST['page'] = pzk_or(@$_REQUEST['page'], @$uri->segments[1]);
					$_REQUEST['element'] = pzk_or(@$_REQUEST['element'], @$uri->segments[2]);
					$_REQUEST['task'] = pzk_or(@$_REQUEST['task'], @$uri->segments[3]);
					if (!REQUEST_MODE)
						$_REQUEST['arguments'] = array_splice($uri->segments, 3);
				}
			}
			if (@$_REQUEST['showQuery']) {
				pre('end route');
				pre($_REQUEST);
			}
			$this->loaded = true;
		}
	}

	public function getRouteInfo($alias) {
		return $this->model->route($alias);
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