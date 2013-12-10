<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		document.menu = null;
		if(!jQuery('#menu').hasClass('disabled')) {
			document.menu = jQuery('#menu').menu();
		}
	});
/*]]>*/
</script>

<ul id="menu" >
	<li class="node"><a>Trang</a>
	<ul>
		<li><a class="icon-16-cpanel" href="<?php echo URL::site('admin');?>">Bảng điều khiển</a></li>
		<li class="separator"><span></span></li>
		<li><a class="icon-16-user" href="<?php echo URL::site('admin/user');?>">Quản lý người dùng</a></li>
		<li><a class="icon-16-user" href="<?php echo URL::site('admin/user/change_password');?>">Đổi mật khẩu</a></li>
		<li class="separator"><span></span></li>
		<li><a class="icon-16-logout" href="<?php echo URL::site('admin/login/logout');?>">Đăng xuất</a></li>
	</ul>
	</li>

	<li class="node"><a>Nội dung</a>
	<ul>
		<li><a class="icon-16-category" href="<?php echo URL::site('admin/news_category');?>">Quản lý chuyên mục</a></li>
		<li><a class="icon-16-article" href="<?php echo URL::site('admin/news_content');?>">Quản lý nội dung tin</a></li>
		<li><a class="icon-16-menu" href="<?php echo URL::site('admin/menu_item');?>">Quản lý menu</a></li>
		<li><a class="icon-16-content" href="<?php echo URL::site('admin/contact');?>">Quản lý liên hệ</a></li>
	</ul>
	</li>

	<li class="node"><a>Sản phẩm</a>
	<ul>
		<li><a class="icon-16-category" href="<?php echo URL::site('admin/product_category');?>">Quản lý danh mục</a></li>
		<li><a class="icon-16-component" href="<?php echo URL::site('admin/manufacturer');?>">Quản lý nhà sản xuất</a></li>
		<li><a class="icon-16-component" href="<?php echo URL::site('admin/origin');?>">Quản lý xuất xứ</a></li>
		<li><a class="icon-16-component" href="<?php echo URL::site('admin/product');?>">Quản lý sản phẩm</a></li>
		<li><a class="icon-16-component" href="<?php echo URL::site('admin/currency');?>">Quản lý tiền tệ</a></li>
	</ul>
	</li>
</ul>
