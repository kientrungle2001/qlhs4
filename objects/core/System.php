<?php
class PzkCoreSystem extends PzkObjectLightWeight {
	public $boundable = false;
	public $libs = array(); 
	public $bootstrap = 'application';
	public $app = false;
	
	/**
	 * Trả về ứng dụng đang chạy
	 * @return PzkCoreApplication
	 */
	public function getApp() {
		if($this->app) return $this->app;
		$request = pzk_element('request');
		$application = $request->query['app'];
		$app = PzkParser::parse('app/'. $application . '/' . $this->bootstrap);
		$this->app = $app;
		return $app;
	}
	
	/**
	 * Trả về đường dẫn theo ứng dụng đang chạy
	 * @param string $path đường dẫn
	 * @return string
	 */
	public static function appPath($path) {
		return 'app/' . $this->getApp()->name . '/' . $path;
	}
	
	/**
	 * Đường dẫn theo hệ thống
	 * @param unknown $path
	 * @return string
	 */
	public function path($path) {
		return BASE_DIR . '/' . $path;
	}
	
}
/**
 * Trả về đối tượng hệ thống
 * @return PzkCoreSystem
 */
function pzk_system() {
	return pzk_store_element('system');
}
?>