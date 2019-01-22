<?php
class PzkCoreRewriteRequest extends PzkObjectLightweight{
	/**
	 * Là tên của trường trong đối tượng pzk_request(). Trường này được đem ra so sánh
	 * @var string
	 */
	public $matcher = 'route'; // 
	
	/**
	 * Mẫu để so sánh
	 * @var string
	 */
	public $pattern = '';
	/**
	 * Giá trị trả về cuối cùng
	 * @var string
	 */
	public $route = false; // target
	
	/**
	 * Phương thức so sánh, có mấy kiều: preg_match, equal, strpos
	 * @var string
	 */
	public $matchMethod = 'preg_match'; // equal, strpos
	
	/**
	 * Phương thức thay thế trong route, kiểu: preg_replace, str_replace
	 * @var string
	 */
	public $replaceMethod = 'preg_replace';
	
	/**
	 * Thay thế toàn bộ
	 * @var boolean
	 */
	public $replaceFullTarget = false;
	
	/**
	 * Thay thế vào đối tượng pzk_request(). viết dạng var1, var2
	 * @var string
	 */
	public $queryParams = false;
	/**
	 * Bổ sung giá trị mặc định vào pzk_request(). Viết dạng chuỗi json
	 * @var json string
	 */
	public $defaultQueryParams = false;
	/**
	 * Gán giá trị theo url cho các đối tượng
	 * @var string
	 */
	public $elementParams = false;
	/**
	 * Giá trị mặc định cho các đối tượng
	 * @var string
	 */
	public $defaultElementParams = false;
	public function init() {
		$request = pzk_element('request');
		$matcher = $this->matcher; $matchSource = $request->$matcher;
		if($this->matchMethod == 'equal') {
			if ($matchSource == $this->pattern) {
				if($this->defaultQueryParams) {
					$params = json_decode($this->defaultQueryParams, true);
					$request->query = array_merge($request->query, $params);
				}
				if($this->defaultElementParams) {
					$params = json_decode($this->defaultElementParams, true);
					foreach($params as $param => $value) {
						$parts = explode('.', $param);
						$element = $parts[0];
						$attr = $parts[1];
						if($e = pzk_element($element)) {
							$e->$attr = $value;
						}
					}
				}
				if($this->route) {
					$request->route = $this->route;
				}
			}
		} else if ($this->matchMethod == 'preg_match') {
			$this->pattern = preg_replace('/\[\*([\w][\w\d]*)\*\]/', '?P<$1>', $this->pattern);
			$this->pattern = str_replace('&lt;', '<', str_replace('&gt;', '>', $this->pattern));
			if(preg_match('/'.$this->pattern.'/is', $matchSource, $matches)) {
				if($this->defaultQueryParams) {
					$params = json_decode($this->defaultQueryParams, true);
					$request->query = array_merge($request->query, $params);
				}
				if($this->queryParams) {
					$keys = explode(',', $this->queryParams);
					foreach($keys as $key) {
						$key = trim($key);
						if(@$matches[$key])
							$request->query[$key] = @$matches[$key];
					}
				}
				
				if($this->defaultElementParams) {
					$params = json_decode($this->defaultElementParams, true);
					var_dump($params);
					foreach($params as $param => $value) {
						$parts = explode('.', $param);
						$element = $parts[0];
						$attr = $parts[1];
						if($e = pzk_element($element)) {
							$e->$attr = $value;
						}
					}
				}
				if($this->elementParams) {
					$keys = explode(',', $this->elementParams);
					foreach($keys as $key) {
						$key = trim($key);
						$parts = explode('.', $key);
						$element = $parts[0];
						$attr = $parts[1];
						if($value = @$matches[str_replace('.', '_', $key)]) {
							if($e = pzk_element($element)) {
								$e->$attr = $value;
							}
						}
					}
				}
				
				if($this->route) {
					$route = $this->route;
					foreach($matches as $index => $value) {
						$route = str_replace('$' . $index, $value, $route);
					}
					$request->route = $route;
				}
			}
		}
	}
	public function build($queryParams) {
	}
}