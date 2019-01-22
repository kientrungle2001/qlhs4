<?php
class PzkApplicationDispatcherElementBased extends PzkApplicationDispatcher {
	public function run($app) {

		$pageName = pzk_or(@$_REQUEST['page'], 'index');
		$pagePath = $app->getPageUri($pageName);

		$page = PzkParser::parse($pagePath);
		foreach(array_keys($_REQUEST) as $key) {
			$matches = array();
			if (preg_match('/^on([\w]+)$/', $key, $matches)) {
				$_REQUEST['task'] = $matches[1];
			}
		}

		if ($element = pzk_or(@$_REQUEST['element'], 'app')) {
			if ($task = pzk_or(@$_REQUEST['task'], 'Default')) {
				$element = _element($element);
				if ($element) {
					$element->execute($task, $_REQUEST);
				}
			}
		}
		if(!@$_REQUEST['isAjax'])
			$page->display();
	}
}
?>