<?php
$request = pzk_element('request');
$query = $request->query;?>

<?php
$currentRegion = $data->getItem();
$currentPage = $data->getPage();
$currentTemplate = $data->getTemplate();
?>
<form name="regionpageapp" id="regionpageapp" method="post" action="{url /ide_app_page_region/editPost}/{currentRegion[id]}">
<input type="hidden" name="id" value="{currentRegion[id]}" />
<input type="hidden" name="title" value="{query[title]}" />
<input type="hidden" name="region" value="{query[region]}" />
<input type="hidden" name="orderNum" value="{query[orderNum]}" />
<input type="hidden" name="eType" value="{query[eType]}" />
<h4>{query[title]}</h4> 
	{children all}
	<input type="submit" value="Cập nhật" />
</form>