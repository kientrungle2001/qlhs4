<?php
class PzkFormController extends PzkController {
	public function validate($rq) {
		$valid = true;
		foreach(_pzk('element.login')->children as $elem) {
			if (!$elem->validate(@$rq[$elem->name])) $valid = false;
		}
		return $valid;
	}
}
?>