<?php
pzk_import('core.db.List');
class PzkEntityCmsPluginListModel extends PzkEntityModel{
	public function process(&$article) {
		if($article)
		foreach($article as $key => $val) {
			preg_match_all('/\{\~list ([^\~]*)\~\}/', $val, $match);
			if($match[1]) {
				foreach($match[1] as $i => $m) {
					$obj = '<core.db.list table="article" '.$m.'/>';
					$obj = pzk_parse($obj);
					$content = $obj->getContent();
					$val = str_replace($match[0][$i], $content, $val);
				}
			}
			$article[$key] = $val;
		}
	}
}