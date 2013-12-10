<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo isset($head) ? $head->title() : 'Presente | Luxury Gift Basket';?></title>
	<meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : 'Presente | Luxury Gift Basket'?>" />
	<meta name="description" content="<?php echo isset($meta_description) ? $meta_description : 'Presente | Luxury Gift Basket'?>" />
	<meta name="revisit-after" content="1 days" />
	<meta name="copyright" content="Nguyễn Văn Nguyên - nguyennv@unisoft.com.vn" />
	<meta name="author" content="Nguyễn Văn Nguyên - nguyennv@unisoft.com.vn" />
<?php 
	echo HTML::script('min/js/front');
	echo $head->script_files();
	echo $head->script_vars();
	echo $head->scripts();
	echo $head->style_files();
	echo $head->styles();
?>

<?php 
	// echo HTML::style('scripts/jquery-ui/jquery-ui.css');
	// echo HTML::style('scripts/fancybox/jquery.fancybox.css');
	echo HTML::style('min/css/front');
?>

<style type="text/css">
.name_wrapper, .border_prods, .infoBoxWrapper, .infoBoxWrapper .infoBoxHeading, .title-t, .box-padd, .listing_padd, .contentContainer.page_un .contentPadd.un, .line { behavior:url(<?php echo URL::site('content/PIE.js')?>)}
</style>
<!--[if lt IE 7]>
	<div style=' clear: both; height: 59px; padding:0 15px 0 15px; position: relative; text-align:center;'> <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." /></a></div>
<![endif]--> 
<!--[if IE]>
	<?php
		echo HTML::style('contents/front/ie_style.css');
	?>
<![endif]-->
<!--[if gt IE 7]>
	<?php
		echo HTML::style('contents/front/ie8_style.css');
	?>
<![endif]-->
<script type="text/javascript">
	preloadImages([
		'<?php echo URL::site('contents/front/images/wrapper_pic.png')?>',
		'<?php echo URL::site('contents/front/images/wrapper_pic-act.png')?>',
		'<?php echo URL::site('contents/front/images/wrapper_pic_border.png')?>',
		'<?php echo URL::site('contents/front/images/wrapper_pic_border-act.png')?>',
		'<?php echo URL::site('contents/front/images/bg_button.png')?>',
		'<?php echo URL::site('contents/front/images/bg_button_rep.gif')?>']);
</script>
</head>
<body>
<div class="bg_body" id="bodyWrapper"><div class="wrapper-padd wrapper">
	<div class="ofh row_1"><div id="header"><div class="cl_both">
		<a class="logo fl_left" href="<?php echo URL::base()?>"><img src="<?php echo URL::site('contents/front/images/logo.png')?>" alt="Home Electronics" title=" Home Electronics " width="244" height="53" /></a>
		<div class="header_block fl_right">
			<div class="cl_both h_block" align="right"><div class="search fl_left ofh"><div class="box_wrapper">
				<?php echo Form::open('search', array('name' => 'quick_find', 'method' => 'post',))?>
					<label class="fl_left">Tìm kiếm: </label>
					<div class="input-width fl_left">
						<div class="width-setter">
						<?php
							echo Form::input(
												'keywords', 'Tìm kiếm...',
												array(
													'size' => '10',
													'maxlength' => '50',
													'class' => 'go fl_left',
													'onblur' => 'if(this.value==\'\') this.value=\'Tìm kiếm...\'',
													'onfocus' => 'if(this.value ==\'Tìm kiếm...\' ) this.value=\'\'',
												)
											);
						?>
						</div>
					</div>
					<input type="image" src="<?php echo URL::site('contents/front/images/button_header_search.png')?>" alt=""  class="button_header_search" />
				<?php echo Form::close()?>
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
				<?php $currencies = Jelly::query('currency')->sort_order()->select_all()->as_array('id', 'name');?>
				<label class="fl_left">Tiền tệ: </label>
				<?php echo Form::open('home/currency', array('name' => 'currencies', 'method' => 'post',))?>
				<?php
					echo Form::select('currency_id', $currencies, $currency->id, array(
								'id' => 'currency_id',
								'class' => 'select',
								'onchange' => 'this.form.submit();',
							));
				?>
				<?php echo Form::close()?>
				</div>
				<div class="languages fl_left">
				<label class="fl_left">Chào mừng đến với Presente</label>
				</div>
			</div></div>
		</div>
	</div></div></div>

	<?php if(isset($breadcrumb) AND count($breadcrumb) > 0){?>
		<?php echo View::factory('front/breadcrumb')->bind('breadcrumb', $breadcrumb)?>
	<?php }?>

	<div class="container_60 ofh row_4">
		<div id="bodyContent" class="grid_43 push_17">
			<div class="none">
				<div class="title-t"><div class="title-icon"></div>
				<h1>Chào mừng tới trang chủ Presente</h1>
				</div><br />
			</div>
			<?php echo isset($content) ? $content : ''?>
		</div><!-- bodyContent //-->
		<div id="columnLeft" class="grid_17 pull_43"><div>
			<?php 
				if(isset($product_category_id)){
					echo Request::factory('home/left_menu/' . $product_category_id)->execute();
				}else{
					echo Request::factory('home/left_menu')->execute();
				}
			?>

			<?php 
				if(isset($origin_id)){
					echo Request::factory('home/left_origin/' . $origin_id)->execute();
				}else{
					echo Request::factory('home/left_origin')->execute();
				}
			?>
			<?php echo Request::factory('home/left_special')->execute();?>
		</div></div>
	</div>
	<div class="container_60 ofh row_5">
		<?php 
			if(isset($menu_item_id)){
				echo Request::factory('home/footer/' . $menu_item_id)->execute();
			}else{
				echo Request::factory('home/footer')->execute();
			}
		?>
		<script type="text/javascript">
		/*<![CDATA[*/
			jQuery('.productListTable tr:nth-child(even)').addClass('alt');
		/*]]>*/
		</script>
	</div>       
</div></div><!-- bodyWrapper //-->
</body>
</html>
