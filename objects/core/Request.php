<?php
class PzkCoreRequest extends PzkObjectLightWeight {
	/**
	 * Đường dẫn URL, chỉ chứa đường dẫn không có ?query=...
	 * @var String
	 */
	public $url;
	/**
	 * Phương thức: là POST, GET,...
	 * @var String
	 */
	public $method;
	/**
	 * Giao thức là http, https,...
	 * @var String
	 */
	public $protocol;
	/**
	 * Host là tên miền như ptnn.vn, qlhs.vn
	 * @var String
	 */
	public $host;
	/**
	 * Cổng kết nối, mặc định là 80
	 * @var int
	 */
	public $port;
	/**
	 * Đường dẫn đầy đủ
	 * @var String
	 */
	public $uri;
	/**
	 * Các biến get
	 * @var Array
	 */
	public $query;
	/**
	 * Các options là các biến đằng sau dấu #
	 * @var Array
	 */
	public $options;
	
	public function init() {
		$this->parse_full_path();
	}
	
	private function parse_full_path()
	{
		$s = &$_SERVER;
		$ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
		$sp = strtolower($s['SERVER_PROTOCOL']);
		
		$protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
		$this->protocol = $protocol;
		
		$port = $s['SERVER_PORT'];
		$this->port = $port;
		$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
		$this->resovledPort = $port;
		$host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
		$this->host = $host;
		$host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
		$uri = $protocol . '://' . $host . $s['REQUEST_URI'];
		$this->uri = $uri;
		$segments = explode('?', $uri, 2);
		$url = $segments[0];
		$this->url = $url;
		$route_uri = $s['REQUEST_URI'];
		$segments2 = explode('?', $route_uri, 2);
		$full_route = $segments2[0];
		$this->full_route = $full_route;
		$segments3 = explode('index.php', $full_route, 2);
		$this->route = @$segments3[1]?@$segments3[1]: @$segments3[0];
		$this->query = $_REQUEST;
		$this->method = $_SERVER['REQUEST_METHOD'];
		return $url;
	}
	
	/**
	 * Kiểm tra xem phương thức là gì
	 * $method = get|post|put|delete|head|options|ajax|ssl|flash|mobile
	 * @param String $method Phương thức cần kiểm tra
	 * @return boolean
	 */
	public function is($method) {
	    return (strtolower($this->method) == strtolower($method));
	}
	
	/**
	 * Xây dựng đường dẫn dựa vào route và query
	 * @example pzk_request()->build('home/category', array('id' => 1)); <br />
	 * Tạo ra đường dẫn http://example.com/home/category?id=1
	 * @param String $route như home/category
	 * @param Array $query mảng các biến get
	 * @param string $options mảng các options
	 * @return string đường dẫn
	 */
	public function build($route, $query = false, $options = false) {
		return BASE_REQUEST . '/' . $route . ($query ? '?' . http_build_query($query) : '') . ($options ? '#' . http_build_query($options) : '');
	}
	
	/**
	 * Xây dựng đường dẫn dựa vào đường dẫn hiện thời
	 * @example Đường dẫn hiện thời là: http://example.com/home/category?page=3<br /> 
	 * pzk_request()->buildCurrent(array('page' => 5)); <br />
	 * Tạo ra đường dẫn http://example.com/home/category?page=5
	 * @param string $query
	 * @param string $options
	 * @return string
	 */
	public function buildCurrent($query = false, $options = false) {
		$route = preg_replace('/^\//', '', $this->route);
		return $this->build($route, $query, $options);
	}
	
	/**
	 * Xây dựng đường dẫn dựa vào controller hiện thời
	 * @example Đường dẫn hiện thời là: http://example.com/home/category?page=3<br /> 
	 * pzk_request()->buildAction('detail', array('id' => 5)); <br />
	 * Tạo ra đường dẫn http://example.com/home/detail?id=5
	 * @param string $action action của đường dẫn mới
	 * @param string $query các biến get
	 * @param string $options
	 * @return string đường dẫn cần tạo
	 */
	public function buildAction($action = false, $query = false, $options = false) {
		$route = $this->get('controller') . '/' . $action;
		return $this->build($route, $query, $options);
	}
	
	/**
	 * Đặt giá trị
	 * @param String $key
	 * @param mixed $value
	 */
	public function set($key, $value) {
		$this->query[$key] = $value;
	}
	
	/**
	 * unset giá trị
	 * @param String $key
	 */
	public function un_set($key) {
		unset($this->query[$key]);
	}
	
	/**
	 * Lấy giá trị ra, nếu ko có thì lấy giá trị mặc định
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($key, $default = NULL) {
		if(isset($this->query[$key])) return $this->query[$key];
		else return $default;
	}
	
	/**
	 * Lấy dữ liệu của url theo phân đoạn
	 * @param int $index vị trí của phân đoạn tính từ 1
	 */
	public function getSegment($index) {
		$parts = explode('/', $this->route);
		return @$parts[$index];
	}
	
	/**
	 * Redirect về một url
	 * @param string $url
	 */
	public function redirect($url) {
		if(strpos($url, '://') !== false) {
			//echo '<script type="text/javascript">window.location="'.$url.'"</script>';
			header('Location: ' . $url);
		} else {
			//echo '<script type="text/javascript">window.location="'.BASE_REQUEST . '/' . $url.'"</script>';
			header('Location: ' . BASE_REQUEST . '/' . $url);
		}
	}
	
	/**
	 * Trả về data được lọc theo mảng
	 * @example
	 * Cho đường dẫn: http://example.com/home/index?page=1&id=2&orderBy=id&orderDir=asc<br />
	 * Lấy ra mảng dữ liệu chứa orderBy, orderDir:<br />
	 * $data = pzk_request()->getFilterData('orderBy, orderDir'); hoặc <br />
	 * $data = pzk_request()->getFilterData('orderBy', 'orderDir'); hoặc <br />
	 * $data = pzk_request()->getFilterData(array('orderBy', 'orderDir')); hoặc <br />
	 * @return multitype:|multitype:mixed
	 */
	public function getFilterData() {
		$fields = array();
		$arguments = func_get_args();
		if(count($arguments) == 0) {
			return $this->query;
		} else if(count($arguments) == 1) {
			if(is_string($arguments[0])) {
				$fields = explodetrim(',', $arguments[0]);
			} else if (is_array($arguments[0])) {
				$fields = $arguments[0];
			}
		} else {
			$fields = $arguments;
		}
		$data = array();
		foreach($fields as $field) {
			$data[$field] = $this->get($field);
		}
		return $data;
	}
	
	/**
	 * Setter, Getter hàm ảo
	 * @param string $name
	 * @param array $arguments
	 * @throws \Exception
	 * @return PzkCoreRequest
	 */
	public function __call($name, $arguments) {
	
		//If it doesn't chech if its a normal old type setter ot getter
		//Getting and setting with $this->getProperty($optional);
		//Getting and setting with $this->setProperty($optional);
		$prefix = substr($name, 0, 3);
		$property = strtolower($name[3]) . substr($name, 4);
		switch ($prefix) {
			case 'get':
				return $this->get($property, @$arguments[0]);
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->set($property, $arguments[0]);
				//Always return this (Even on the set)
				return $this;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
}
/**
 * 
 * @param string $var
 * @param string $value
 * @return PzkCoreRequest|mixed
 */
function pzk_request($var = NULL, $value = NULL) {
	$request = pzk_element('request');
	if($var == NULL) return $request;
	if($value == NULL) return $request->get($var);
	return $request->set($var, $value);
}

/**
 * Redirect về một đường dẫn url
 * @param string $url
 */
function pzk_redirect($url) {
	return pzk_request()->redirect($url);
}