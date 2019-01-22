<style>
.pagination a.active {
	color: green;
}
</style>
<?php
$fields = explode(',', $data->select);
foreach($fields as $key => $field) {
	$parts = explode('.', $field);
	$fields[$key] = array_pop($parts);
}
?>
<table>
	<tr>
		<td><input type="checkbox" name="checkAll" />Check All</td>
		<?php foreach($fields as $field) { ?>
		<td><?php echo $field?></td>
		<?php } ?>
	</tr>
	<?php
	foreach($data->items as $item) {?>
	<tr>
		<td><input type="checkbox" name="ids[<?php echo $item['id']?>]" /></td>
		<?php foreach($fields as $field) { ?>
		<td>
		<?php if ($field == 'createdTime') { ?> 
			<?php echo date('d/m/y h:i:s', $item[$field])?>
		<?php } else { ?> 
			<?php echo $item[$field] ?> 
		<?php } ?> 
	<?php } ?>
		</td>
	</tr>
<?php } ?>
</table>
<div class="pagination">
Trang 
<?php for($i = 0; $i < $data->pageCount; $i++) { ?>
	<a class="page <?php if (@$data->page == $i){echo 'active';} ?>" 
			href="javascript:void(0)"
			onclick="pzk.elements.list.gotoPage(<?php echo $i ?>)"><span><?php echo ($i + 1) ?></span></a>
	&nbsp;&nbsp;
<?php } ?>
</div>
