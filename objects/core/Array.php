<?php
class PzkCoreArray extends PzkObjectLightWeight {
	public $data = array();
	public function setParam($param, $value) {
		$this->data[$param] = $value;
		return $this;
	}
	public function getParam($param) {
		return isset($this->data[$param]) ? $this->data[$param] : NULL;
	}
	public function getInt($param) {
		$val = $this->getParam($param);
		if($val === NULL) return NULL;
		return intval($val);
	}
	public function getIdentify($param) {
		$val = $this->getParam($param);
		if($val === NULL) return NULL;
		preg_match('/^[\w]+[\w\d_]*/', $val, $match);
		if(isset($match[0])) return $match[0];
		return NULL;
	}
	public function clear() {
		$this->data = array();
		return $this;
	}
	public function getParams() {
		return $this->data;
	}
	public function getData() {
		return $this->data;
	}
	public function setData($data) {
		$this->data = $data;
		return $this;
	}
	public function toJson() {
		return json_encode($this->data);
	}
	public function toXml($root = 'root') {
		$xml = new SimpleXMLElement('<'.$root.'/>');
		array_to_xml($this->data, $xml);
		return $xml->asXML();
	}
	
	public function fromXml($xmlString, $path = '', $root = false) {
		$xmlarray = array();
		$xml = simplexml_load_string($xmlString); 
		if($path) {
			$xml = $xml->xpath($path);
		}
		$xmlarray = array(); // this will hold the flattened data 
		//XMLToArrayFlat($xml, $xmlarray, $path, $root);
		$xmlarray = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));
		$this->data = $xmlarray;
		return $this;
	}
	
	public function fromJson($data) {
		$this->data = json_decode($data, true);
		return $this;
	}
	
	public function isRss() {
		if (isset($this->data['channel']['item'])) { 
			return true; 
		} else { 
			return false; 
		}
	}
	
	public function isAtom() {
		if ($this->data['entry']) { 
			return true; 
		} else { 
			return false; 
		}
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
				return $this->getParam($property);
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->setParam($property, $arguments[0]);
				//Always return this (Even on the set)
				return $this;
			case 'has':
				return isset($this->data[$property]);
				break;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
	
	public function groupBy($fields = array()) {
		$rs = array();
		foreach($this->data as $row) {
			$r = &$rs;
			foreach($fields as $field) {
				if(!isset($r[$row[$field]])) {
					$r[$row[$field]] = array();
				}
				$r = &$r[$row[$field]];
			}
			$r[] = $row;
		}
		return $rs;
	}
	
	public static $sortFields;
	public function sortBy($fields = array()) {
		self::$sortFields = $fields;
		usort($this->data, 'sort_by_fields');
	}
	
	public function indexById() {
		$rs = array();
		foreach($this->data as $row) {
			$rs[$row['id']] = $row;
		}
		return $rs;
	}
}

/**
 * @return PzkCoreArray
 */
function pzk_array() {
	return pzk_element('array')->clear();
}

function XMLToArrayFlat($xml, &$return, $path='', $root=false) 
{ 
    $children = array(); 
    if ($xml instanceof SimpleXMLElement) { 
        $children = $xml->children(); 
        if ($root){ // we're at root 
            $path .= '/'.$xml->getName(); 
        } 
    } 
    if ( count($children) == 0 ){ 
        $return[$path] = (string)$xml; 
        return; 
    } 
    $seen=array(); 
    foreach ($children as $child => $value) { 
        $childname = ($child instanceof SimpleXMLElement)?$child->getName():$child; 
        if ( !isset($seen[$childname])){ 
            $seen[$childname]=0; 
        } 
        $seen[$childname]++; 
        XMLToArrayFlat($value, $return, $path.'/'.$child.'['.$seen[$childname].']'); 
    } 
}

function array_to_xml(array $arr, SimpleXMLElement $xml)
{
    foreach ($arr as $k => $v) {
        is_array($v)
            ? array_to_xml($v, $xml->addChild($k))
            : $xml->addChild($k, $v);
    }
    return $xml;
}

function sort_by_fields($a, $b) {
	$fields = PzkCoreArray::$sortFields;
	foreach($fields as $field) {
		if($a[$field[0]] > $b[$field[0]]) {
			if($field[1] == 'asc')
				return 1;
			return -1;
		} else if($a[$field[0]] < $b[$field[0]]) {
			if($field[1] == 'asc')
				return -1;
			return 1;
		}
	}
	return 1;
}