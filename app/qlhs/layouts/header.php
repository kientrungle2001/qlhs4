<div class="logo"><img src="/<?php echo pzk_app()->getUri('images/logo.png')?>" /></div>
<div class="separator"><?php $wds = array('Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy')?>
<div class="inner">
	<span class="currentTime"><?php echo $wds[date('w')]?> ngày <?php echo date('d/m/Y, H:i')?></span>
	<select class="categories">
		<option value="0">Chuyên mục</option>
		<option value="1">Xã hội</option>
		<option value="2">Thế thao</option>
		<option value="3">Giải trí</option>
	</select>
	<div class="clear"></div>
</div>
</div>