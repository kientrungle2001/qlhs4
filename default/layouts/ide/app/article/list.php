<?php 
$articles = $data->items;
?>
<div>
<h2>Danh sách các bài viết</h2>
	{each $articles as $article}
	<div style="margin: 10px; padding: 10px; border: 1px solid black;">
		<a href="{url /ide_app_article}/edit/{article[id]}">{article[title]}</a>
		<a href="{url /ide_app_article}/delete/{article[id]}">[x]</a>
	</div>
	{/each}
	<h3>Action</h3>
	<div style="margin: 10px; padding: 10px; border: 1px solid black;">
		<a href="{url /ide_app_article}/add/{data.parentId}">Tạo article</a>
	</div>
</div>