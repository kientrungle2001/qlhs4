<?php
class PzkInclude extends PzkObject {
	public $boundable = false;
	public $layout = 'include';
	public $pattern = false;
	public $file = false;
	public $page = false;
	public function init() {
		if (@$this->pattern) {
			$source = PzkParser::parseLayout($this->pattern, $this);
			$this->append(PzkParser::parse($source));
		}
		
		if (@$this->page) {
			$this->append(PzkParser::parse($this->page));
		}
		
		if ($this->file) {
			$file = 'applications/' . _app()->name . '/pages/include/' . $this->file;
			//echo $file;
			$this->append(_parse($file));
		}
	}
}
?>