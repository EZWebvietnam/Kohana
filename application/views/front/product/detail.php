<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script type="text/javascript">
/*<![CDATA[*/
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
/*]]>*/
</script>
<div class="contentContainer page_un">
	<div class="contentPadd un"><div class="prods_info decks big"><div class="forecastle">
		<ol class="masthead">
			<li class="port_side">
			<div id="piGal">
			<ul>
				<?php foreach($images as $image){?>
				<li class="wrapper_pic_div">
				<a href="<?php echo URL::site('upload/product/' . $image->name)?>" target="_blank" rel="fancybox" class="prods_pic_bg" style="width:230px;height:195px;"><img src="<?php echo URL::site('upload/product/thumbs/' . $image->name)?>" alt="" width="228" height="193" title="" style="width:230px;height:195px;margin:0px 0px 0px 0px;" />
					<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
						<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
							<div class="wrapper_pic_bl"><div class="wrapper_pic_br"><div class="wrapper_pic_zoom" style="width:230px;height:195px;"></div></div></div>
						</div></div></div>
					</div></div></div>
				</a>
				</li>
				<?php }?>
			</ul>
			</div>
			<script type="text/javascript">
			/*<![CDATA[*/
			jQuery(function(){
				var myWidth = 71;
				var myHeight = myWidth * 0.84649122807018;
				jQuery('#piGal ul').bxGallery({
				  maxwidth: '',
				  maxheight: '',
				  thumbwidth: myWidth,
				  thumbheight: myHeight,
				  thumbcontainer: 238,
				  load_image: '<?php echo URL::site('contents/front/images/spinner.gif')?>'
				})
			});
			jQuery("#piGal a[rel^='fancybox']").fancybox({
			  cyclic: true
			});
			/*]]>*/
			</script>
			</li>
			<li class="starboard_side">
				<div class="info">
				<h2><?php echo $product->name?></h2>
				<?php $product_price = (float) $product->price / (float) $currency->rate;?>
				<h2 class="price"><b></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp;<?php echo round($product_price)?> <?php echo $currency->symbol?></span></h2>
				<div class="options">
					<p class="options-title">Nồng độ:&nbsp;<?php echo $product->alcohol_level?> %</p>
					<p class="options-title">Dung tích:&nbsp;<?php echo $product->capacity?> ml</p>
					<p class="options-title">Xuất xứ:&nbsp;<?php echo $product->origin->name?></p>
					<p class="options-title">Màu sắc:&nbsp;<?php echo $product->color?></p>
				</div>
				<div class="desc desc_padd"><?php echo Utils::decode_data($product->description)?></div>
			</div> 
			</li>
		</ol>
	</div></div></div>

<?php if(isset($other_products) AND count($other_products) > 0){?>
	<div class="contentPadd"><div class="prods_content prods_table">
	<?php 
		$count = 0;
		foreach($other_products as $key => $product){
			$count++;
			$product_url = URL::site('product/' . $product->id . '_' . $product->friendly_url);
			$product_image = URL::site('upload/product/thumbs/' . $product->thumb_image);
			$product_price = (float) $product->price / (float) $currency->rate;
	?>
		<?php if(($count % 2) != 0){?>
		<ul id="row-<?php echo (int) $key / 2;?>" class="row">
			<li class="wrapper_prods first" style="width:319px;">
			<div class="border_prods">
				<div class="name_wrapper"><div class="name name_padd  equal-height" style="min-height: 31px;"><div>
					<span><a href="<?php echo $product_url?>"><?php echo $product->name?></a></span>
				</div></div></div>
				<div class="prods_padd">
					<div style="width:167px;height:142px;" class="pic_padd wrapper_pic_div">
						<a style="width:167px;height:142px;" href="<?php echo $product_url?>" class="prods_pic_bg"><img width="167" height="142" style="width:167px;height:142px;margin:0px 0px 0px 0px;" title="<?php echo $product->name?> - <?php echo $product->sku?>" alt="<?php echo $product->name?> - <?php echo $product->sku?>" src="<?php echo $product_image?>">
							<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
								<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
									<div class="wrapper_pic_bl"><div style="width:167px;height:142px;" class="wrapper_pic_br"></div></div>
								</div></div></div>
							</div></div></div>
						</a>
					</div>
					<div class="box-padd ofh">
						<div class="price un"><b class="fl_left"></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp;<?php echo round($product_price)?> <?php echo $currency->symbol?></span></div>
						<div class="desc desc_padd"><?php echo Text::limit_words($product->sort_description, 15)?>...</div>
						<div class="button__padd">
							<div onmouseover="this.className='bg_button2-act';" onmouseout="this.className='bg_button2';" class="bg_button2"><div class="button-tl"><div class="button-tr"><div class="button-t">
								<a role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" id="tdb1" href="<?php echo $product_url?>">
									<span class="ui-button-icon-primary ui-icon ui-icon-cart"></span>
									<span class="ui-button-text">Xem chi tiết</span>
								</a>
							</div></div></div></div>
						</div>
					</div>
				</div>
			</div>
			</li>
			<li class="prods_vseparator"><img width="1" height="1" alt="" src="<?php echo URL::site('contents/front/images/spacer.gif')?>"></li>
		<?php }else{?>
			<li class="wrapper_prods last" style="width:319px;">
				<div class="border_prods">
					<div class="name_wrapper"><div class="name name_padd  equal-height" style="min-height: 31px;"><div>
						<span><a href="<?php echo $product_url?>"><?php echo $product->name?></a></span>
					</div></div></div>
					<div class="prods_padd">
						<div style="width:167px;height:142px;" class="pic_padd wrapper_pic_div">
						<a style="width:167px;height:142px;" href="<?php echo $product_url?>" class="prods_pic_bg"><img width="167" height="142" style="width:167px;height:142px;margin:0px 0px 0px 0px;" title="<?php echo $product->name?> - <?php echo $product->sku?>" alt="<?php echo $product->name?> - <?php echo $product->sku?>" src="<?php echo $product_image?>">
							<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
								<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
									<div class="wrapper_pic_bl"><div style="width:167px;height:142px;" class="wrapper_pic_br"></div></div>
								</div></div></div>
							</div></div></div>
						</a>
						</div>
						<div class="box-padd ofh">
							<div class="price un"><b class="fl_left"></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp;<?php echo round($product_price)?> <?php echo $currency->symbol?></span></div>
							<div class="desc desc_padd"><?php echo Text::limit_words($product->sort_description, 15)?>...</div>
							<div class="button__padd">
								<div onmouseover="this.className='bg_button2-act';" onmouseout="this.className='bg_button2';" class="bg_button2"><div class="button-tl"><div class="button-tr"><div class="button-t">
									<a role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" id="tdb1" href="<?php echo $product_url?>">
										<span class="ui-button-icon-primary ui-icon ui-icon-cart"></span>
										<span class="ui-button-text">Xem chi tiết</span></a>
								</div></div></div></div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
		<ul>
			<li class="prods_hseparator first last"><img width="1" height="1" alt="" src="<?php echo URL::site('contents/front/images/spacer.gif')?>"></li>
		</ul>
		<?php }?>
	<?php }?>
	</div></div>
<?php }?>
</div>
<script type="text/javascript">
        $(document).ready(function(){ 			
			 var row_list = $('.row');
			 row_list.each(function(){
				 new equalHeights($('#' + $(this).attr("id")));
			  });			 			 			  			  			  			  			   
        })      
</script>
