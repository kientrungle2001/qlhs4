<?php $pages = $data->getPages();?>
{each $pages as $page}
{page[title]} | <input type="number" name="ordering[{page[id]}]" onchange="buildMenuOrdering({page[id]}, this.value)" /> Order 
| <input type="checkbox" name="enabled[{page[id]}]" value="{page[id]}" onchange="buildMenuEnabled({page[id]}, this.checked)"/> Show<br />
{/each}
<input type="checkbox" name="ulmenu" value="1" onchange="buildUlMenu(this.checked)"/> UL menu?<br />
<input id="code_holder" type="hidden" name="code" />
<input id="style_holder" type="hidden" name="style" />
<div id="code_result"></div>
<script type="text/javascript">
var pages = <?php echo json_encode($pages);?>;
var ulMenu = false;
function buildUlMenu(choice) {
	ulMenu = choice;
	buildMenu();
}
function buildMenuOrdering(pageId, ordering) {
	for(var i = 0; i < pages.length; i++) {
		var page = pages[i];
		if(page.id == pageId)
			page.ordering = parseInt(ordering);
	}
	buildMenu();
}
function buildMenuEnabled(pageId, enabled) {
	for(var i = 0; i < pages.length; i++) {
		var page = pages[i];
		if(page.id == pageId)
			page.enabled = enabled;
	}
	buildMenu();
}
function buildMenu() {
	var selecteds = []; var result = '';
	for(var i = 0; i < pages.length; i++) {
		var page = pages[i];
		if(typeof page.enabled != 'undefined' && page.enabled) {
			selecteds.push(page);
		}
	}
	selecteds.sort(function(a, b){return a.ordering-b.ordering;});
	if(!ulMenu) {
		for(var i = 0; i < selecteds.length; i++) {
			result += ' <a href="{url /ide_app_page}/preview/'+selecteds[i].id+'">'+selecteds[i].title+'</a>';
		}
	} else {
		result += '<ul>';
		for(var i = 0; i < selecteds.length; i++) {
			result += '<li><a href="{url /ide_app_page}/preview/'+selecteds[i].id+'">'+selecteds[i].title+'</a></li>';
		}
		result += '</ul>';
	}
	$('#code_holder').val(result);
	$('#code_result').html(result);
}
</script>