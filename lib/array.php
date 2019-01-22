<?php
function explodetrim($delim, $str) {
	$arr = explode($delim, $str);
	foreach($arr as $i => $e) {
		$arr[$i] = trim($e);
	}
	return $arr;
}

function min_array($array, $field) {
	$arr = array();
	foreach($array as $row) {
		$arr[] = $row[$field];
	}
	return min($arr);
}
function max_array($array, $field) {
	$arr = array();
	foreach($array as $row) {
		$arr[] = $row[$field];
	}
	return max($arr);
}
function count_array($arr, $value) {
	$total = 0;
	foreach($arr as $v) {
		if($v == $value) {
			$total++;
		}
	}
	return $total;
}