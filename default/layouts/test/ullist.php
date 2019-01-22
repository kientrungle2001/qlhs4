<?php
$items = $data->getItems();
?>
<ul>
{each $items as $item}
<li>{item[name]}
</li>
{/each}
</ul>