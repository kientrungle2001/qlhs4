<?php
$item = $data->getItem();
$displayFields = explode(',',$data->displayFields);
$plugins = $data->getPlugins();
foreach($plugins as $plugin) {
	$plugin->process($item);
}
?>
<!-- hien thi hinh anh - gallery -->
{ifprop showImages=true}
	<?php preg_match_all('/img src="([^"]+)"/', $item['images'], $matches);
	$imgs = @$matches[1];
	?>
	<div>
	{each $imgs as $img}
	<?php if($img) { ?>
		<div style="display: block; float: left; width: 162px; height: 110px;margin: 5px; border: 1px solid #ddd;">
		<a href="javascript:void(0);" rel="{img}" onclick="showImage('{img}');">{thumb 160x108 $img}</a>
		</div>
	<?php } ?>
	{/each}
	<div style="clear:both;"></div>
	<script>
	function showImage(url) {
		var $img = $('<img src="'+url+'">');
		$img.click(function(){
			$img.remove();
		});
		var attrs = {'position': 'fixed', 'top': 50, 'left': 300, 'width': $(window).width() - 600, 'height': 'auto', 'right': 300, 'border': '1px solid #ddd', 'padding': '5px'};
		for(var name in attrs) {
			$img.css(name, attrs[name]);
		}
		$('body').append($img);
	}
	</script>
	</div>
{/if}
<!-- hien thi noi dung -->
{each $displayFields as $field}
{? 	$field = trim($field); 
	$fieldTag = $field . 'Tag'; 
	$fieldTag=@$data->$fieldTag?@$data->$fieldTag: 'div'; 
	$value = @$item[$field]; ?}
<{fieldTag} class="{data.classPrefix}{field}">{value}</{fieldTag}>
{/each}

<!-- hien thi cac object con -->
{children all}

<!-- hien thi cac navigation next, prev -->
{ifprop showNav=true}
{?
	$next = $data->getNextItem(array('categories', $item['categories']));
	$prev = $data->getPrevItem(array('categories', $item['categories']));
?}
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
		<?php if($prev) { ?>
		<a href="/{prev[alias]}" style="padding: 5px; color: yellow;">Bài trước</a>
		<?php } ?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
		<?php if($next) { ?>
		<a href="/{next[alias]}" style="padding: 5px; color: yellow;">Bài tiếp</a>
		<?php } ?>
		</div>
	</div>
{/if}

<!-- hien thi facebook comment-->
{ifprop facebookComment=true}
<div style="background: #ddd;">
	<fb:comments width="100%" xid="16626" href="http://{_SERVER[HTTP_HOST]}{_SERVER[REQUEST_URI]}"></fb:comments>
</div>
{/if}