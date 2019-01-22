{ec all}
{each $data->items as $item}
<input type="checkbox" name="{e name}[{item[value]}]"
	value="{item[value]}">{item[label]}<br />
{/each}