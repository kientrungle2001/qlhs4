{data.region}<a href="{url /ide_app_page_region/add}/{data.pageId}?region={data.region}">[+]</a>
<a style="display: none;" href="javascript:pzk.elements.{data.id}.add('{data.region}', '#region-{data.region}')">[add]</a>
<br />
<blockquote id="region-{data.region}">
<?php $regions = $data->items; ?>
{each $regions as $region}
<div>
<a href="{url /ide_app_page_region/edit}/{region[id]}">{region[title]}</a>
<a href="{url /ide_app_page_region/delete}/{region[id]}">[x]</a>
</div>
{/each}
</blockquote>