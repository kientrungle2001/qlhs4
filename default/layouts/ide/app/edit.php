<?php $app = $data->getItem(); 
$templates = $data->getTemplates();
$currentTemplate = $data->getCurrentTemplate();
?>
<h2>{app[title]}</h2>
<form name="app" id="app" class="show" method="post" action="{url /ide_app/editPost}/{app[id]}">
	<input type="hidden" name="id" value="{app[id]}" />
	Tên ứng dụng : <br />
	<input name="title" value="{app[title]}" /> <br />
	Domain : <br />
	<input name="domain" value="{app[domain]}" /> <br /> 
	Từ khóa : <br />
	<input name="keywords" value="{app[keywords]}" /> <br />
	Mô tả : <br />
	<input name="description" value="{app[description]}" /> <br />
	Giao diện : <br />
	<select name="templateId" value="{app[templateId]}" onchange="templateChange(this.value)">
		{each $templates as $template}
		<?php
			$selected = '';
			if($template['id'] == @$app['templateId']) {
				$selected = ' selected="selected"';
			}
		?>
		<option value="{template[id]}" {selected}>{template[title]}</option>
		{/each}
	</select><br />
	Layout :<br />
	<select name="layout">
		<?php if(isset($currentTemplate['layouts'])) { ?>
		<?php foreach($currentTemplate['layouts'] as $layout) { ?>
			<option value="{layout[value]}">{layout[label]}</option>
		<?php } ?>
		<?php } else { ?>
		<option value="index">Trang chủ</option>
		<?php } ?>
	</select><br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#app select[name=layout]').val('{app[layout]}');
	//$('#regionpageapp select[name=region]').val('{currentRegion[region]}');
	function templateChange(templateId) {
		$.ajax({url: '{url /ide_template/regionlistjson}?templateId=' + templateId,
			dataType: 'json', success: function(layouts) {
				
				$('#app select[name=layout]').html('');
				
				if(layouts) {
					
					for(var i = 0; i < layouts.length; i++) {
						var layout = layouts[i];
						$('#app select[name=layout]').append('<option value="'+layout.value+'">'+layout.label+'</option>');
					}
					$('#app select[name=layout]').val('{app[layout]}');
				
				}
			}
		});
	}
</script>