<?php
class PzkPClass {
	public $page;
	public $arr;
	public $content;
	public static $current = NULL;
	public function PzkPClass($page) {
		$this->page = $page;
		$this->content = '';
	}
	
	public function load() {
		$this->arr = array();
		$content = $this->content = @file_get_contents($this->page . '.pconfig');
		$this->parse();
		return $this;
	}
	
	public function parse() {
		$matches = array();
		preg_match_all('/([\w\d_]+)\.([\w\d_]+)[\s]*\{([^\}]*)\}/', $this->content, $matches);
		if($matches && @$matches[1][0] && @$matches[2][0] && @$matches[3][0]) {
			$count = count ($matches[1]); 
			for($i = 0; $i < $count; $i++) {
				$elem = $matches[1][$i];
				$config = $matches[2][$i];
				$params = trim($matches[3][$i]);
				$params = explode(';', $params);
				foreach($params as $param) {
					$pair = explode(':', $param);
					if(count($pair) == 2) {
						$this->set($elem, $config, trim($pair[0]), trim($pair[1]));
					}
				}
			}
		}
	}
	
	public function save() {
	}
	
	public function generate() {
	}
	
	public function get($elem, $config, $attr = false) {
		if ($attr)
			return @$this->arr[$elem][$config][$attr];
		else
			return @$this->arr[$elem][$config];
	}
	
	public function set($elem, $config, $attr = array(), $value = false) {
		if (is_array($attr)) {
			if (!isset($this->arr[$elem][$config])) $this->arr[$elem][$config] = array();
			$this->arr[$elem][$config] = array_merge($this->arr[$elem][$config], $attr);
		} else {
			$this->arr[$elem][$config][$attr] = $value;
		}
	}
	
	public static function instance($page = false) {
		
		static $insts = array();
		
		if (!$page) {
			return $current;
		}
		if (!@$insts[$page]) {
			$insts[$page] = new PzkPClass($page);
		}
		
		return $insts[$page];
	}
	
	public static function setCurrent($page = false) {
		return self::$current = self::instance($page);
	}
	
	public static function getCurrent() {
		return self::$current;
	}
}