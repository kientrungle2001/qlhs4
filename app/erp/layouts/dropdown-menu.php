<!-- Source: https://catalin.red/dist/uploads/2011/03/css3-dropdown-menu-demo.html -->
<ul id="menu">
	<li><a href="{url /}">Tổng quan</a></li>
	<li><a href="{url /}">THAP</a></li>
	<li><a href="{url /phanquyen}">Phân quyền</a></li>
	<li><a href="{url /thamso}">Tham số</a></li>
	<li>
	<a href="#"><?php echo pzk_session('username')?></a>
	<ul>
	<li><a href="#"><?php echo pzk_session('fullname')?> (<?php echo pzk_session('usertype')?>)</a></li>
	<li><a href="{url /account/logout}">Đăng xuất</a></li>
	</ul>
	</li>
</ul>