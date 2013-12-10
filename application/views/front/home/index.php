<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="contentContainer page_un">
	<div class="title-t">
		<div class="title-icon"></div>
		<h1 class="cl_both ">Sản phẩm</h1>
	</div>
	<div class="contentPadd">
		<div class="prods_content prods_table">
		<?php if(isset($products) AND count($products) > 0){?>
			<?php 
				$count = 0;
				foreach($products as $key => $product){
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
		<?php }?>
		</div>
	</div>
	<script type="text/javascript">
	/*<![CDATA[*/
        jQuery(document).ready(function(){ 			
			 var row_list = jQuery('.row');
			 row_list.each(function(){
				 new equalHeights(jQuery('#' + jQuery(this).attr("id")));
			  });
        })
        jQuery(document).ready(function(){ 			
			 var row_list2 = $('.row2');
			 row_list2.each(function(){
				 new equalHeights2(jQuery('.sub_categories'));
			  });			 			 			  			  			  			  			   
        })
	/*]]>*/
	</script>
</div>