<?php
class PzkCoreConfigDb extends PzkObjectLightWeight {
	public function set($key, $value) {
		$item = _db()->select('*')->from('config')->where('`mkey`=\'' . $key . '\'')->result_one();
		if($item) {
			$row = array('mkey' => $key, 'mvalue' => json_encode($value));
			_db()->update('config')->set($row)->where('id='.$item['id'])->result();
		} else {
			$row = array('mkey' => $key, 'mvalue' => json_encode($value));
			_db()->insert('config')->fields(implode(',', array_keys($row)))->values(array($row))->result();
		}
		return $this;
	}
	
	public function get($key, $default = null) {
		$item = _db()->select('*')->from('config')->where('`mkey`=\'' . $key . '\'')->result_one();
		if($item) {
			return json_decode($item['mvalue'], true);
		} else {
			return $default;
		}
	}
}