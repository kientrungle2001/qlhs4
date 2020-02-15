<span id="wrapper-{data.id}" class="ajax-reload-selector" data-table="classes" data-id="{data.id}">
	<input class="ajax-reload-input" id="{data.id}" type="hidden" {attr name} {attr value} {attr onChange}/>
	<span id="label-{data.id}" data-field="name" class="ajax-reload-label">(Trống)</span>
</span>
<a href="#" onclick='pzk.elements.{data.id}.showCourseSelectorDialog({prop defaultFilters}); return false;'>[Chọn Lớp]</a>
<a href="#" onclick="pzk.elements.{data.id}.resetCourseSelector(); return false;">[x Bỏ chọn]</a>
