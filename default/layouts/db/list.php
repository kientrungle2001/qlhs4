<?php $items = $data->getItems(); 
$layoutType = $data->getProp('layoutType', 'div');
$displayFields = explode(',',$data->displayFields);
?>
<!-- hien thi theo kieu ul -->
{ifvar layoutType=ul}
<ul>
{each $items as $item}
	<li>{item[name]}</li>
{/each}
</ul>
{/if}

<!-- hien thi theo kieu div -->
{ifvar layoutType=div}
<div class="core_db_list">
{each $items as $item}
	<div class="core_db_list_item">
	{each $displayFields as $field}
	{? 	$field = trim($field); 
		$fieldTag = $field . 'Tag'; 
		$fieldTag=@$data->$fieldTag?@$data->$fieldTag: 'div';
		$value = @$item[$field]; 
	?}
	<{fieldTag} class="{data.classPrefix}{field}" rel="{item[id]}">
		{? if(@$data->titleField==$field && @$data->linkTitle) : ?}
		<a href="/{item[alias]}">
		{? endif;?}
	{value}
		{? if(@$data->titleField==$field && @$data->linkTitle) : ?}
		</a>
		{? endif;?}
	</{fieldTag}>
	{/each}
	</div>
{/each}
</div>
{/if}
