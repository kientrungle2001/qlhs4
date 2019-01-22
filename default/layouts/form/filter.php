<?php 
$items = _db()->query($data->sql);
?>
<div {attrs id, class}>
<div class="selected_filter">Đang chọn: <span class="selected_value" style="color: green;">Tất cả</span> <a href="javascript:void(0)" onclick="pzk.elements.{prop id}.clear();(function() {{prop onSelect}{prop onselect}}).call(pzk.elements.{prop id});" class="selected_clear"></a></div>
<?php if (@$data->displayType == 'ul') { ?>
<ul class="filter_list">
{each $items as $item}
	<li><a href="javascript:void(0)" onclick="pzk.elements.{prop id}.select('{item[value]}', '{item[label]}');(function() {{prop onSelect}{prop onselect}}).call(pzk.elements.{prop id});" rel="{item[value]}">{item[label]}</a></li>
{/each}
</ul>
<?php } else { ?>
<div class="filter_list">
{each $items as $item}
	<a href="javascript:void(0)" onclick="pzk.elements.{prop id}.select('{item[value]}', '{item[label]}');(function() {{prop onSelect}{prop onselect}}).call(pzk.elements.{prop id});" rel="{item[value]}">{item[label]}</a><br />
{/each}
</div>
<?php } ?>
</div>