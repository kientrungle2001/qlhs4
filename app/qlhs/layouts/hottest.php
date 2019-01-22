{each $data->items as $item}
<div class="hostest">
	<h2 class="title"><a href="/{item[alias]}-{item[id]}.html">{item[title]}</a></h2>
	<div>
		<img class="image" src="{item[image]}"/>
		<p class="brief">
			{item[brief]}
		</p>
	</div>
</div>
{/each}