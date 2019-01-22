<?php $currentPage = $data->getItem(); 
$currentTemplate = $data->getCurrentTemplate();
$bases = $data->getBasedPages();
?>
<h3><a href="{url /page}/{currentPage[id]}" target="_blank">{currentPage[title]}</a></h3>
<form name="pageapp" id="pageapp" class="show" method="post" action="{url /ide_app_page/editPost}/{currentPage[id]}">
	<input type="hidden" name="id" value="{currentPage[id]}" />
	<input type="hidden" name="type" value="{currentPage[type]}" />
	<input type="hidden" name="subType" value="{currentPage[subType]}" />
	Tên trang : 
	<input name="title" value="{currentPage[title]}" /> <br />
	Layout :
	<select name="layout">
		<?php if(isset($currentTemplate['layouts'])) { ?>
		<?php foreach($currentTemplate['layouts'] as $layout) { ?>
			<option value="{layout[value]}">{layout[label]}</option>
		<?php } ?>
		<?php } else { ?>
		<option value="index">Trang chủ</option>
		<?php } ?>
	</select><br />
	Dựa trên trang : 
	<select name="basePageId">
		<option value="">None</option>
		{each $bases as $base}
			<option value="{base[id]}">{base[title]}</option>
		{/each}
	</select> <br />
	Từ khóa : 
	<input name="keywords" value="{currentPage[keywords]}" /> <br />
	Mô tả : 
	<input name="description" value="{currentPage[description]}" /> <br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#pageapp select[name=layout]').val('{currentPage[layout]}');
	$('#pageapp select[name=basePageId]').val('{currentPage[basePageId]}');
</script>