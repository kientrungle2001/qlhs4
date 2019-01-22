<?php
$items = $data->getSearchResult();
?>
<h3>Kết quả tìm kiếm</h3>
<ul id="ul_student_list">
	<?php 
	$first = true;
	foreach($items as $item) { ?>
	<li class="student-{item[id]} <?php if($first) echo 'student_active'; ?>"><a href="javascript:void(0)" onclick="pzk_student.detail({item[id]})">{item[name]}</a><br />
	Lớp: {item[classNames]} <br /> 
	Phone: {item[phone]}
	</li>
	<?php 
	if($first) $first = false;
	} ?>
</ul>
<script type="text/javascript">
	$('#ul_student_list li:first a').click();
</script>