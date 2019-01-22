<?php
/**
 * View object
 *
 */
class PzkObject {
	public $children;
	public $layout = 'empty';
	public $scriptable = false;
	public $scriptTo = 'head';
	public $cacheable = false;

	public $userable = false;
	public $role = false;
	public $cacher = 'filecache';
	public $xml = false;
	public $xpath = '';
	public $json = false;

	/**
	 * cac tham so dung de cache, viet cach nhau boi dau phay
	 */

	public $cacheParams = 'id';

	/**
	 * Cac tham so dung de cho ham toArray, viet cach nhau boi dau phay
	 */
	public $arrayParams = false;

	/**
	 * Id cua parent element
	 */
	public $pzkParentId = false;

	/**
	 * Id lon nhat cua element
	 */
	public static $maxId = 0;

	/**
	 * Css lien quan den object, css nay se duoc cache lai
	 */
	public $cssLink = false;

	/**
	 * Css nay khong can cache lai
	 */
	public $cssExternalLink = false;

    public $less = false;
    public $lessExteralLink = false;
	/**
	 * Js lien quan den object, js nay se duoc cache lai
	 */
	public $jsLink = false;

	/**
	 * Js nay khong can cache lai
	 */
	public $jsExternalLink = false;
	
	public static $selectors = array();

	/**
	 * Ham khoi tao mot object voi cac attribute cua no truyen
	 * dang mang
	 * @param $attrs la cac thuoc tinh cua doi tuong
	 */
	public function __construct($attrs) {
		foreach($attrs as $key => $value) $this->$key = $value;
		$this->children = array();
		if (!@$this->id) {
			$this->id = 'uniqueId' . self::$maxId;
			self::$maxId++;
		}

		$this->css();
		$this->javascript();
		if($this->xml) {
			$this->importXml();
		}
		if($this->json) {
			$this->importJson();
		}
	}
	
	public function importXml() {
		if(pzk_element('array')) {
			$file = BASE_DIR . '/' . pzk_app()->getUri('xml/' . $this->xml . '.xml');
			if(file_exists($file)) {
				$content = file_get_contents($file);
				$arr = pzk_array();
				$arr->fromXml($content, $this->xpath);
				$data = $arr->getData();
				$arr->clear();
				foreach($data as $key => $val) {
					$this->$key = $val;
				}
			}
		}
	}
	
	public function importJson() {
		if(pzk_element('array')) {
			$file = BASE_DIR . '/'. pzk_app()->getUri('json/' . $this->json . '.json');
			if(file_exists($file)) {
				$content = file_get_contents($file);
				$arr = pzk_array();
				$arr->fromJson($content);
				$data = $arr->getData();
				$arr->clear();
				foreach($data as $key => $val) {
					$this->$key = $val;
				}
			}
		}
	}

    /**
     * Ham them less cho trang
     */
    public function less() {
        $head = pzk_element($this->scriptTo);
        debug($head);die();
        $head->append(pzk_parse('<script src="/3rdparty/less.min.js"></script>'));
        if ($this->lessLink != false) {
            if(!$this->scriptTo) {
                $elem = pzk_element($this->scriptTo);
                $elem->append(pzk_parse('<html.less src="'.BASE_REQUEST.'/default/skin/'.pzk_app()->name.'/less/'.$this->cssLink.'.less" />'));
            } else {
                if($page = pzk_page())
                    $page->addObjLess($this->cssLink);
            }

        }
        if ($this->lessExternalLink != false) {
            if($this->scriptTo) {
                $elem = pzk_element($this->scriptTo);
                $elem->append(pzk_parse('<html.less src="'.$this->cssExternalLink.'" />'));
            } else {
                if($page = pzk_page()) {
                    $page->addExternalLess($this->cssExternalLink);
                }
            }

        }

    }


    /**
	 * Ham them css cho trang
	 */
	public function css() {
		if ($this->cssLink != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<html.css src="'.BASE_REQUEST.'/default/skin/'.pzk_app()->name.'/css/'.$this->cssLink.'.css" />'));
			} else {
				if($page = pzk_page())
					$page->addObjCss($this->cssLink);
			}

		}
		if ($this->cssExternalLink != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<html.css src="'.$this->cssExternalLink.'" />'));
			} else {
				if($page = pzk_page()) {
					$page->addExternalCss($this->cssExternalLink);
				}
			}

		}

	}
	
	/**
	 * Add javascript tag for object
	 */
	public function javascript() {
		if ($this->scriptable === true || $this->scriptable === 'true') {
			
			if(@$this->scriptTo) {
				$element = pzk_element($this->scriptTo);
				if($element) {
					$element->append(pzk_parse('<html.js src="'.BASE_URL.'/js/'.implode('/', $this->fullNames).'.js" />'));
				}
			} else {
				$page =pzk_page();
				if ($page) {
					$page->addObjJs($this->tagName);
				}
			}
		}
		
		if ($this->jsLink != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<html.js src="'.BASE_REQUEST.'/default/skin/'.pzk_app()->name.'/js/'.$this->jsLink.'.js" />'));
			} else {
				if($page = pzk_page())
					$page->addObjCss($this->cssLink);
			}
			
		}
		if ($this->jsExternalLink != false) {
			if($this->scriptTo) {
				$elem = pzk_element($this->scriptTo);
				$elem->append(pzk_parse('<html.js src="'.$this->jsExternalLink.'" />'));
			} else {
				if($page = pzk_page()) {
					$page->addExternalCss($this->jsExternalLink);
				}	
			}
			
		}
	}

	/**
	 * Ham nay chay khi doi tuong vua duoc khoi tao,
	 * cac doi tuong con cua no chua duoc khoi tao
	 */
	public function init() {
	}

	/**
	 * Ham nay dung de hien thi doi tuong
	 */
	public function display() {
		$this->script();
		$this->html();
		
	}

	/**
	 * Ham nay tao 1 instance javascript cho doi tuong hien thi
	 */
	public function script() {
		if ($this->scriptable === true || $this->scriptable === 'true') {
			$page = pzk_page();
			if ($page) {
				$page->addJsInst($this->toArray());
			}
		}
	}

	/**
	 * Ham nay tra ve html cua doi tuong can hien thi
	 * Neu request no cache hoac cau hinh cua doi tuong
	 * co cacheable = false thi se ko cache
	 * nguoc lai thi se cache
	 */
	public function html() {
		if (!@$_REQUEST['noCache'] && ($this->cacheable === true
		|| $this->cacheable === 'true')) {
			$this->cache();
		} else {
			echo $this->getContent();
		}
		return true;
	}

	/**
	 *	Ham cache lai noi dung hien thi
	 * 	Dua tren cac tham so dua vao de cache
	 * 	Cache nay theo 1 loai cacher nao do:
	 * 	file cache hay memcache hoac db cache, session cache,... 
	 */
	public function cache() {
		$key = $this->cacher.'.' . $this->hash();
		if (($content = pzk_store($key)) === NULL) {
			$content = $this->getContent();
			pzk_store($key, $content);
		}
		echo $content;
	}

	/**
	 *	Tra ve html cua doi tuong can hien thi
	 * 	truong hop nay la truong hop khi khong co cache
	 */
	public function getContent() {
		return PzkParser::parseLayout($this->layout, $this, true);
	}

	/**
	 * 	Tao key cho doi tuong can hien thi (de cache)
	 */
	public function hash() {
		$cacheParams = explode(',',$this->cacheParams);
		$hash ='';
		foreach($cacheParams as $param) {
			$param = trim($param);
			$hash .= @$this->$param;
		}
		return md5($hash);
	}

	/**
	 *	Append mot child object 
	 */
	public function append($obj) {
		$obj->pzkParentId = @$this->id;
		$this->children[] = $obj;
	}
	
	/**
	 * Prepend mot child object
	 */
	public function prepend($obj) {
		$obj->pzkParentId = @$this->id;
		array_unshift($this->children, $obj);
	}
	
	/**
	 * Insert mot child object vao vi tri index
	 */
	public function insertObject($obj, $index) {
		$obj->pzkParentId = @$this->id;
		array_splice($this->children, $index, 0, $obj);
	}
	
	/**
	 * Tra ve vi tri cua doi tuong trong danh sach anh em cua no
	 */
	public function index() {
		if ($parent = $this->getParent()) {
			return array_search($this, $parent->children);
		}
		return -1;
	}
	
	/**
	 * Insert mot doi tuong vao ngay truoc doi tuong
	 */
	public function before(&$obj) {
		if ($parent = $this->getParent()) {
			$parent->insert($obj, $this->index());
		}
	}
	
	/**
	 * Insert mot doi tuong vao ngay sau doi tuong
	 */
	public function after(&$obj) {
		if ($parent = $this->getParent()) {
			$parent->insert($obj, $this->index() + 1);
		}
	}
	
	/**
	 * Lay ra cha cua doi tuong do
	 */
	public function getParent() {
		if ($this->pzkParentId) {
			return pzk_store_element($this->pzkParentId);
		}
		return NULL;
	}
	
	/**
	 * Lay ra tat ca cac con cua doi tuong theo selector
	 * @param $selector: selector can chon dua theo cau truc
	 * 	tagName[name=value][name=value]
	 */
	public function getChildren($selector = 'all') {
		if ($selector == 'all') return $this->children;
		$rslt = array();
		$attrs = $this->parseSelector($selector);
		foreach($this->children as $child) {
			if ($child->matchAttrs($attrs)) {
				$rslt[] = $child;
			}
		}
		return $rslt;
	}
	
	/**
	 * Tim mot element la con cua doi tuong goc, theo 1 selector
	 */
	public function findElement($selector = 'all') {
		$attrs = $this->parseSelector($selector);
		foreach($this->children as $child) {
			if ($child->matchAttrs($attrs)) {
				return $child;
			} else {
				if ($elem = $child->findElement($selector)) {
					return $elem;
				}
			}
		}
		return null;
	}
	
	/**
	 * Tim cac elements theo selectors
	 */
	public function findElements($selector = 'all') {
		$attrs = $this->parseSelector($selector);
		$result = array();
		foreach($this->children as $child) {
			if ($child->matchSelector($attrs)) {
				$result[] = $child;
			}
			$childElements = $child->findElements($selector);
			foreach($childElements as $elem) {
				$result[] = $elem;
			}
		}
		return $result;
	}
	
	/**
	 * tim parent theo selector
	 */
	public function findParent($selector) {
		if ($parent = $this->getParent()) {
			if($parent->matchSelector($selector)) {
				return $parent;
			}
		}
		return null;
	}
	
	/**
	 * Tim cac parent theo selector
	 */
	public function findParents($selector) {
		$parents = array();
		$cur = $this->getParent();
		while($cur) {
			if ($cur->matchSelector($selector)) {
				$parents[] = $cur;
			}
			$cur = $cur->getParent();
		}
		return $parents;
	}
	
	/**
	 * Hien thi tat ca cac children theo selector
	 */
	public function displayChildren($selector = 'all') {
		$children = $this->getChildren($selector);
		if(is_array($children)) {
			foreach($children as $child) {
				$child->display();
			}
		} else $children->display();
	}
	
	public function matchSelector($selector) {
		$attrs = $this->parseSelector($selector);
		if ($this->matchAttrs($attrs)) {
			return true;
		}
		return false;
	}
	
	/**
	 * khop cac thuoc tinh
	 */
	public function matchAttrs($attrs) {
		foreach($attrs as $key => $attr) {
			if(!isset($attr['comparator'])) continue;
			switch($attr['comparator']) {
				case '=':
					if (@$this->$key != $attr['value']) {
						return false;
					}
					break;
				case '!=':
				case '<>':
					if (@$this->$key == $attr['value']) {
						return false;
					}
					break;
				case '^=':
					if (strpos(@$this->$key, $attr['value']) !== 0) {
						return false;
					}
					break;
				case '*=':
					if (strpos(@$this->$key, $attr['value']) === FALSE) {
						return false;
					}
					break;
			}
		}
		return true;
	}
	
	/**
	 * Parse selector tra ve 1 mang cac dieu kien loc
	 *
	 * @param $selector
	 * @return mang kieu kien
	 */
	function parseSelector($selector) {
		if (isset(self::$selectors[$selector])) return self::$selectors[$selector];
		$pattern = '/^([\w\.\d]+)?((\[[^\]]+\])*)?$/';
		$subPattern = '/\[([^=\^\$\*\!\<]+)(=|\^=|\$=|\*=|\!=|\<\>)([^\]]+)\]/';
		if (preg_match($pattern, $selector, $match)) {
			preg_match_all($subPattern, $match[2], $matches);
			$attrs = array();

			$tagName = $match[1];
			if ($tagName) {
				$attrs['tagName'] = $tagName;
			}

			for($i = 0; $i < count($matches[1]); $i++) {
				$attrs[$matches[1][$i]] = array('comparator' => $matches[2][$i], 'value' => $matches[3][$i]);
			}
			
			self::$selectors[$selector] = $attrs;

			return $attrs;
		}
		self::$selectors[$selector] = array();
		return array();
	}

	/**
	 * Ham nay chay khi tat ca cac child object cua no da duoc khoi tao
	 */
	public function finish() {
	}
	
	/**
	 * Ham nay tra ve array mo ta doi tuong dua theo arrayParams
	 */
	public function toArray() {
		$result = (array)$this;
		unset($result['children']);
		if(@$this->excludeParams) {
			$arrayParams = explode(',', $this->excludeParams);
			foreach($arrayParams as $param) {
				$param = trim($param);
				if (isset($this->$param)) {
					unset($result[$param]);
				}
			}
		}
		return $result;
	}
	
	public function translate($text) {
		if(pzk_language()) {
			return pzk_language()->translateText(implode('/', $this->fullNames), $text);
		} else {
			return $text;
		}
	}
	
	public function getProp($prop, $default = null) {
		if(isset($this->$prop)) return $this->$prop;
		return $default;
	}
	
	public function getModel($model) {
		return pzk_loader()->getModel($model);
	}
	
	public function __call($name, $arguments) {

		//Getting and setting with $this->property($optional);

		if (property_exists(get_class($this), $name)) {


			//Always set the value if a parameter is passed
			if (count($arguments) == 1) {
				/* set */
				$this->$name = $arguments[0];
			} else if (count($arguments) > 1) {
				throw new \Exception("Setter for $name only accepts one parameter.");
			}

			//Always return the value (Even on the set)
			return $this->$name;
		}

		//If it doesn't chech if its a normal old type setter ot getter
		//Getting and setting with $this->getProperty($optional);
		//Getting and setting with $this->setProperty($optional);
		$prefix = substr($name, 0, 3);
		$property = strtolower($name[3]) . substr($name, 4);
		switch ($prefix) {
			case 'get':
				return $this->$property;
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->$property = $arguments[0];
				//Always return this (Even on the set)
				return $this;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
	
	public $events = array();
	
	public function addEventListener($event, $handler){
		if(!isset($this->events[$event])) {
			$this->events[$event] = array();
		}
		$this->events[$event][] = $handler;
	}
	
	public function onEvent($event) {
		$str = '';
		$rq = pzk_request();
		$controller = $rq->get('controller');
		$BASE_REQUEST = BASE_REQUEST;
		$eventHandlers = isset($this->events[$event]) ? $this->events[$event]: array();
		foreach ($eventHandlers as $handler) {
			$str .= "(function(data) {
			jQuery.ajax({url: '$BASE_REQUEST/$controller/$handler',type: 'post', data:data, success: function(resp) {
				eval(resp);
			}});
		})(data);";
		}
		$str = "(function(data){ {$str} })";
		return $str;
	}
}
