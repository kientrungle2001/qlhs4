<ul class="pzk_filter"></ul>
<ul class="pzk_list">
<?php
	foreach($data->items as $item) {?>
	<li>
		<h1><?php echo $item['title']?></h1>
		<p><?php echo @$item['brief']?></p>
	</li>
<?php
	}
?>
</ul>
<ul class="pzk_pagination"></ul>