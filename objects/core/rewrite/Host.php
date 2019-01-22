<?php
pzk_import('core.rewrite.Request');
class PzkCoreRewriteHost extends PzkCoreRewriteRequest {
	public $matcher = 'host';
	public $matchMethod = 'equal';
	public $name = '';
	public $app = '';
	public $controller = 'Home';
	public $action = 'index';
	public function init() {
		$this->pattern = $this->name;
		$this->defaultQueryParams='{"app":"'.$this->app.'", "controller": "'.$this->controller.'", "action": "'.$this->action.'"}';
		parent::init();
	}
}