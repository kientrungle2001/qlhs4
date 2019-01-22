<select {ea id} {ea name}>
<option value=""></option>
<?php
foreach($data->items as $item) {
	$selected = '';
	if ($item['value'] == @$data->value) {
		$selected = 'selected="selected"';
	}
?>
<option value="{item[value]}" {selected}>{item[label]}</option>
<?php
}
?>
</select>