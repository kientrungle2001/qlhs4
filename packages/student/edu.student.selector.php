<?php
$name = $data->name;
?>
<span id="wrapper-{data.id}" class="ajax-reload-selector" data-table="student" data-id="{data.id}">
	<input class="ajax-reload-input" id="{data.id}" type="hidden" {attr name} {attr value} {attr onChange}/>
	<span id="label-{data.id}" data-field="name" class="ajax-reload-label">(Trống)</span>
</span>
<a href="#" onclick='pzk.elements.{data.id}.showStudentSelectorDialog({prop defaultFilters}); return false;'>[Chọn Học sinh]</a>
<a href="#" onclick="pzk.elements.{data.id}.resetStudentSelector(); return false;">[x Bỏ chọn]</a>
<script>
	function studentRowStyler(index, row) {
		var style = '';
		if(row.color !== '') {
			style += 'color:' + row.color + ';';
		}
		
		if(row.fontStyle !== '') {
			if(row.fontStyle === 'bold')
				style += 'font-weight: bold;';
			else if(row.fontStyle === 'italic') {
				style += 'font-style: italic;';
			} else if(row.fontStyle === 'underline') {
				style += 'text-decoration: underline;';
			}
		}
		if(style === '') {
			var studentDate = new Date(row.startStudyDate);
			var currentDate = new Date();
			return (currentDate.getTime() - studentDate.getTime() > 365 * 24 * 3600 * 1000) ?  'color: grey;': '';
		} else {
			console.log(style);
			return style;
		}
	}
</script>
