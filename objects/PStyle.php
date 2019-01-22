<?php
class PzkPStyle extends PzkObject {
	public $src = 'style';
	public $arr = array();
	public function init() {
		ob_start();
		require_once BASE_DIR . '/' . _app()->getUri('style.php');
		$content = ob_get_contents();
		ob_end_clean();
		file_put_contents(BASE_DIR . '/public/' . _app()->name . '_style.php', $content);
		$matches = array();
		preg_match_all('/([\.#]?[\w\d_-]+)[\s]*\{([^\}]*)\}/', $content, $matches);
		foreach($matches[1] as $index => $selector) {
			$arr = pzk_properties($matches[2][$index], array('str2arr'));
			$this->arr[$selector] = $arr;
		}
	}
}
?>