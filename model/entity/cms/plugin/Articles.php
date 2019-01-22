<?php
pzk_import('core.db.List');
class PzkEntityCmsPluginArticlesModel extends PzkEntityModel{
	public function process(&$article) {
		if($article)
		foreach($article as $key => $val) {
			preg_match_all('/\{\~articles([^\~]*)\~\}/', $val, $match);
			if($match[1]) {
				foreach($match[1] as $i => $m) {
					$obj = '<core.db.list table="article" displayFields="name,brief" nameTag="h4" linkTitle="true" titleField="name" parentMode="true" parentField="categoryId" '.$m.'/>';
					$obj = pzk_parse($obj);
					$content = $obj->getContent();
					$val = str_replace($match[0][$i], $content, $val);
				}
			}
			$article[$key] = $val;
		}
	}
}