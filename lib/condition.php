<?php
/**
 * Enter description here...
 *
 * @return unknown
 */
function pzk_or() {
	foreach(func_get_args() as $var) {
		if (!!$var) return $var;
	}
}

/**
 * Enter description here...
 *
 * @return unknown
 */
function pzk_and() {
	$rslt = false;
	foreach(func_get_args() as $var) {
		$rslt = $var;
		if (!$var) return FALSE;
	}
	return $rslt;
}