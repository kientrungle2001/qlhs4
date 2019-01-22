{? $src = $data->src;
if(strpos($src, 'http://') === false) {
	$src = '/default/skin/' . pzk_app()->name . '/images/' . $src;
}
?}
<img id="{prop id}" class="{prop class}" src="/default/skin/<?php echo pzk_app()->name; ?>/images/{prop src}" style="width: {prop width}; height: {prop height}; {prop style}" />