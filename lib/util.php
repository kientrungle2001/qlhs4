<?php
function pre($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

/**
 * Ham hien thi memory tu byte sang dang MBs, KBs, Bytes
 *
 * @param Integer $mem Memory usage
 * @return Hien thi memory duoi dang MBs, KBs, Bytes
 */
function display_mem($mem) {
	$rslt = array();
	$nots = array('Bytes', 'KBs', 'MBs');
	while($mem != 0) {
		$mod = $mem % 1024;
		$mem = ($mem - $mod) / 1024;
		$rslt[] = $mod;
	}
	$str = '';
	for($i = count($rslt) - 1; $i > -1; $i--) {
		$str .= $rslt[$i] . ' ' . $nots[$i] . ' ';
	}
	return $str;
}