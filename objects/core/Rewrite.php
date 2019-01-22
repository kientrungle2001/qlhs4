<?php
class PzkCoreRewrite extends PzkObjectLightWeight {
	public $pattern;
	public $target;
	public function init() {
		$request = pzk_element('request');
		$route = trim($_REQUEST['route']);
		if(preg_match('/'. $this->pattern.'/', $route, $match)) {
			$result = $this->target;
			foreach($match as $index => $value) {
				$result = str_replace('$' . $index, $value, $result);
				$rkey = 'request'.$index;
				if(@$this->$rkey) {
					$_REQUEST[$this->$rkey] = $value;
					$request->query[$this->$rkey] = $value;
				}
			}
			$_REQUEST['route'] = $result;
		}
	}
}