<?php 
$data->items = _db()->query($data->sql);
?>
<select {attr id} {attr name} {attr multiple} class="easyui-combobox2" {attr onChange}>
<option value="">{prop label}</option>
<?php
if(isset($data->items) && is_array($data->items)) {
foreach($data->items as $item) {
	$selected = '';
	$rel = '';
	$rel2 = '';
	if ($item['value'] == @$data->value) {
		$selected = 'selected="selected"';
	}
	if(isset($data->dependence) && isset($data->dependenceField)) {
		$rel = 'rel="'.@$item[$data->dependenceField].'"';
	}
	
	if(isset($data->dependence2) && isset($data->dependenceField2)) {
		$rel2 = 'rel2="'.@$item[$data->dependenceField2].'"';
	}
?>
<option value="{item[value]}" {selected} {rel} {rel2}>{item[label]}</option>
<?php
}
}
?>
</select>

<?php if(isset($data->dependence)) { ?>
<?php $randomField = 'randomField' . rand(0, 1000000); 
$randomTime = rand(1000, 1500);
?>
<span id="{randomField}">&nbsp;</span>
<script type="text/javascript">
	setTimeout(function() {
		var $form = $('#{randomField}').parents('form');
		$form.find('[name={prop dependence}]').change(function() {
			if($(this).val() == '') {
				$form.find('[name={prop name}]').find('option').removeClass ('hidden-{prop dependence}');
			} else {
				$form.find('[name={prop name}]').find('option').removeClass ('hidden-{prop dependence}');
				$form.find('[name={prop name}]').find('option[rel!="'+$(this).val()+'"]').addClass('hidden-{prop dependence}');
			}
		});
	}, {randomTime});
</script>
<?php } ?>

<?php if(isset($data->dependence2)) { ?>
<?php $randomField2 = 'randomField2' . rand(0, 1000000); 
$randomTime2 = rand(1000, 1500);
?>
<span id="{randomField2}">&nbsp;</span>
<script type="text/javascript">
	setTimeout(function() {
		var $form = $('#{randomField2}').parents('form');
		$form.find('[name={prop dependence2}]').change(function() {
			if($(this).val() == '') {
				$form.find('[name={prop name}]').find('option').removeClass ('hidden-{prop dependence2}');
			} else {
				$form.find('[name={prop name}]').find('option').removeClass ('hidden-{prop dependence2}');
				$form.find('[name={prop name}]').find('option[rel2!="'+$(this).val()+'"]').addClass('hidden-{prop dependence2}');
			}
		});
	}, {randomTime});
</script>
<?php } ?>