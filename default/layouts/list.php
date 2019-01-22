<ul class="pzk_list">
<?php
$field = pzk_or(@$data->titleField, 'subject'); 
foreach($data->items as $item){ ?>
	<li><a href="/<?php echo @$item['alias'] ?>"><?php echo $item[$field] ?></a></li>
	<?php } ?>
</ul>
