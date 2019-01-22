<?php
class StringUtil {
	
	public $str;
	
	public function toAlias() {
		
	}
	
	public function toReadable() {
		
	}
	
	public function toKhongdau() {
		
	}
	
	public function cutWords($words, $maxLength = false) {
		$strs = explode(' ', $this->str);
		$wordCount = count($strs);
		$min = $words > $wordCount ? $wordCount : $words;
		$rslt = @$strs[0];
		for($i = 1; $i < $min; $i++) {
			 $rslt .= ' ' . $strs[$i];
		}
		if ($min != $wordCount) {
			$rslt .= '...';
		}
		return $rslt;
	}
	
	public function cutId($maxLength) {
		
	}
	
	public function setStr($str) {
		$this->str = $str;
		return $this;
	}
}
?>