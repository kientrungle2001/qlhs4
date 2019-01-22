<?php
require_once BASE_DIR . '/3rdparty/Smarty-2.6.28/libs/Smarty.class.php';
class PzkObjectSmarty extends PzkObject{
	public function getContent() {
		$smarty = new Smarty();
		$smarty->compile_check = true;
		$smarty->debugging = false;
		$smarty->caching = true;
		$smarty->cache_lifetime = 120;
		$vars = array_keys((array)$this);
		foreach($vars as $var) {
			//if('children' !== $var) {
				$smarty->assign($var, $this->$var);
			//}
		}
		$smarty->assign('data', $this);
		$filePath = PzkParser::getFilePath($this->layout . '.php', 'app/' . @pzk_app()->name . '/layouts|default/layouts');
		return $smarty->fetch($filePath);
	}
}