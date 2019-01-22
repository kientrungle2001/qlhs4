<?php
class PzkFormSubmit extends PzkFormElement {
	public $boundable = false;
	public $layout = 'submit';
	public $task = false;
	public $onclick = '';
	public function finish() {
		if ($this->task) {
			$this->onclick .= '$(this).parents(\'form\').children(\'[name=task]\').val(\'' . $this->task . '\');';
		}
	}
}
?>