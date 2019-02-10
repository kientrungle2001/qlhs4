<!-- Source: https://catalin.red/dist/uploads/2011/03/css3-dropdown-menu-demo.html -->
<?php if(0):?>
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
<?php endif; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Quản trị</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{url /}">Tổng quan <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{url /}">THAP</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{url /khachhang}">Khách hàng</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{url /phanquyen}">Phân quyền</a>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php echo pzk_session('username')?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#"><?php echo pzk_session('fullname')?> (<?php echo pzk_session('usertype')?>)</a>
          <a class="dropdown-item" href="{url /account/logout}">Đăng xuất</a>
        </div>
      </li>
    </ul>
  </div>
</nav>