<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="ofh row_1"><div id="header"><div class="cl_both">
	<a class="logo fl_left" href="<?php echo URL::base()?>"><img src="<?php echo URL::site('contents/front/images/store_logo.png')?>" alt="Home Electronics" title=" Home Electronics " width="244" height="53" /></a>
	<div class="header_block fl_right">
		<div class="cl_both h_block" align="right"><div class="search fl_left ofh"><div class="box_wrapper">
			<form name="quick_find" action="advanced_search_result.php" method="post">
				<label class="fl_left">Tìm kiếm: </label>
				<div class="input-width fl_left">
					<div class="width-setter">
					<input type="text" name="keywords" value="Tìm kiếm ..." size="10" maxlength="30" class="go fl_left" onblur="if(this.value=='') this.value='Tìm kiếm ...'" onfocus="if(this.value =='Tìm kiếm ...' ) this.value=''" />
					</div>
				</div>
				<input type="image" src="<?php echo URL::site('contents/front/images/button_header_search.png')?>" alt=""  class="button_header_search" />
			</form>
		</div></div></div>
		<div class="cl_both" align="right">
			<?php 
				if(isset($menu_item_id)){
					echo Request::factory('home/menu/' . $menu_item_id)->execute();
				}else{
					echo Request::factory('home/menu')->execute();
				}
			?>
		</div>
		<div class="cl_both ofh" align="right"><div class="navigation_block">
			<div class="currencies fl_right">
			<label class="fl_left">Tiền tệ: </label>
			<form name="currencies" action="<?php echo URL::site('change_currency')?>" method="post">
				<select name="currency" onchange="this.form.submit();" class="select">
					<option value="USD" selected="selected">U.S. Dollar</option>
					<option value="EUR">Euro</option>
				</select>
			</form>
			</div>
			<div class="languages fl_left">
			<label class="fl_left">Chào mừng đến với Presente</label>
			</div>
		</div></div>
	</div>
</div></div></div>
