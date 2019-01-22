<div>
<h2>Danh sách người dùng</h2>
<?php
$field = pzk_or(@$data->titleField, 'subject'); 
foreach($data->items as $item){ ?>
	<div style="margin: 10px;padding: 10px; border:1px solid black;"><a href="{url /ide_app}/list/<?php echo @$item['id'] ?>"><?php echo $item[$field] ?></a></div>
	<?php } ?>
</div>
