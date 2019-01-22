<ul>
{each $data->items as $item}
	<li><h3><a href="mailto:{item[email]}">{item[fullName]}</a> 
		at {date $item['createdTime']}</h3>
{item[content]}
	</li>
{/each}
</ul>