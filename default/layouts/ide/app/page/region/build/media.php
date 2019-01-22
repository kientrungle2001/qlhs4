<?php
$build = pzk_element('build');
$item = $build->getItem();
?>
Url: <input type="text" name="url" value="{item[url]}" onchange="mediaObj.url = this.value; mediaObj.preview();"/><br />
Width: <input type="text" name="width" value="{item[width]}" onchange="mediaObj.width = this.value; mediaObj.preview();"/><br />
Height: <input type="text" name="height" value="{item[height]}" onchange="mediaObj.height = this.value; mediaObj.preview();"/><br />
<div id="media-preview">
</div>
<input type="hidden" name="code" id="region-code" />
<script>
var mediaObj = {
	url: '{item[url]}',
	width: '{item[width]}',
	height: '{item[height]}',
	preview: function() {
		var matches = this.url.match(/[\\?\\&]v=([^\\?\\&]+)/);
		if(matches.length) {
			var videoId = matches[1];
			var videoObj = '<object width="'+this.width+'" height="'+this.height+'" data="http://www.youtube.com/v/'+videoId+'" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/'+videoId+'" /></object>';
			$('#media-preview').html(videoObj);
			$('#region-code').val(videoObj);
		}
	}
}
mediaObj.preview();
</script>