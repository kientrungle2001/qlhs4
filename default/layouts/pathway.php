<a href="/index.php">Trang chủ</a>
<?php
	foreach($data->items as $item) {?> &gt; 
	<a href="<?php echo _app_url($item['alias']); ?>">
		<?php echo $item['title'] ?>
	</a>
<?php }?>