<?php
class PzkIdeWizard extends PzkObject {
	public $source = false;
	public function gotoStep($step) {
		$app = pzk_element('app');
		$this->append($stepObj = pzk_parse($app->getPageUri('wizard/' . $this->source . '/step' . $step )));
		return $stepObj;
	}
}