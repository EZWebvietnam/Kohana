<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="title-t"><div class="title-icon"></div><h1>Xuất xứ:&nbsp;<?php echo $origin->name?></h1></div>

<div class="result result1_top"><div class="result1_bottom"><div class="cl_both result_top_padd ofh">
	<div class="fl_left result_left"><span>Hiển thị <strong><?php echo $pagination->current_first_item?></strong> đến <strong><?php echo $pagination->current_last_item?></strong></span> (của <strong><?php echo $pagination->total_items?></strong> sản phẩm)</div>
	<div class="fl_right result_right">Trang: &nbsp;<?php echo ($pagination->total_pages > 1) ? $pagination : 1?>&nbsp;</div>
</div></div></div>

<div class="contentContainer page_un">
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
		<ul id="row-<?php echo (int) $key / 2;?>" class="row row2">
			<li class="wrapper_prods first" style="width:319px;">
				<div class="border_prods">
					<div class="name_wrapper"><div class="name name_padd  equal-height" style="min-height: 31px;"><div>
						<span><a href="<?php echo $product_url?>"><?php echo $product->name?></a></span>
					</div></div></div>
					<div class="prods_padd">
						<div style="width:167px;height:142px;" class="pic_padd wrapper_pic_div">
						<a style="width:167px;height:142px;" href="<?php echo $product_url?>" class="prods_pic_bg"><img width="165" height="140" style="width:167px;height:142px;margin:0px 0px 0px 0px;" title="<?php echo $product->name?> - <?php echo $product->sku?>" alt="<?php echo $product->name?> - <?php echo $product->sku?>" src="<?php echo $product_image?>">
							<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
								<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
									<div class="wrapper_pic_bl"><div style="width:167px;height:142px;" class="wrapper_pic_br"></div></div>
								</div></div></div>
							</div></div></div>
						</a>
						</div>
						<div class="box-padd ofh">
							<div class="price un"><b class="fl_left"></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp;<?php echo round($product_price)?> <?php echo $currency->symbol?></span></div>
							<div class="desc desc_padd"><?php echo Text::limit_words($product->sort_description, 17)?>...</div>
							<div class="button__padd">
								<div onmouseover="this.className='bg_button2-act';" onmouseout="this.className='bg_button2';" class="bg_button2"><div class="button-tl"><div class="button-tr"><div class="button-t">
								<a role="button" href="<?php echo $product_url?>" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary">
								<span class="ui-button-icon-primary ui-icon ui-icon-cart"></span>
								<span class="ui-button-text">Xem chi tiết</span>
								</a>
								</div></div></div></div>
							</div>
						</div>
					</div>
					<div class="listing_padd">
						<table cellspacing="0" cellpadding="0" border="0" class="listing">
						<tr>
							<td><b><font>Nồng độ&nbsp;:</font></b></td>
							<td align="right"><font><?php echo $product->alcohol_level?> %</font></td>
						</tr><tr>
							<td><b><font>Xuất xứ&nbsp;:</font></b></td>
							<td align="right"><font><a href="<?php echo URL::site('origin/' . $product->origin->id . '_' . Utils::url_lize($product->origin->name))?>"><?php echo $product->origin->name?></a></font></td>
						</tr><tr>
							<td><b><font>Dung tích&nbsp;:</font></b></td>
							<td align="right"><font><?php echo $product->capacity?> ml</font></td>
						</tr><tr>
							<td><b><font>Màu sắc&nbsp;:</font></b></td>
							<td align="right"><font><?php echo $product->color?></font></td>
						</tr>
						</table>
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
						<a style="width:167px;height:142px;" href="<?php echo $product_url?>" class="prods_pic_bg"><img width="165" height="140" style="width:167px;height:142px;margin:0px 0px 0px 0px;" title="<?php echo $product->name?> - <?php echo $product->sku?>" alt="<?php echo $product->name?> - <?php echo $product->sku?>" src="<?php echo $product_image?>">
						<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
							<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
								<div class="wrapper_pic_bl"><div style="width:167px;height:142px;" class="wrapper_pic_br"></div></div>
							</div></div></div>
						</div></div></div>
						</a>
						</div>
						<div class="box-padd ofh">
							<div class="price un"><b class="fl_left"></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp; <?php echo round($product_price)?> <?php echo $currency->symbol?></span></div>
							<div class="desc desc_padd"><?php echo Text::limit_words($product->sort_description, 17)?>...</div>
							<div class="button__padd">
								<div onmouseover="this.className='bg_button2-act';" onmouseout="this.className='bg_button2';" class="bg_button2"><div class="button-tl"><div class="button-tr"><div class="button-t">
									<a role="button" href="<?php echo $product_url?>" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary">
									<span class="ui-button-icon-primary ui-icon ui-icon-cart"></span>
									<span class="ui-button-text">Xem chi tiết</span></a>
								</div></div></div></div>
							</div>
						</div>
					</div>
					<div class="listing_padd">
						<table cellspacing="0" cellpadding="0" border="0" class="listing"><tr>
						<tr>
							<td><b><font>Nồng độ&nbsp;:</font></b></td>
							<td align="right"><font><?php echo $product->alcohol_level?> %</font></td>
						</tr><tr>
							<td><b><font>Xuất xứ&nbsp;:</font></b></td>
							<td align="right"><font><a href="<?php echo URL::site('origin/' . $product->origin->id . '_' . Utils::url_lize($product->origin->name))?>"><?php echo $product->origin->name?></a></font></td>
						</tr><tr>
							<td><b><font>Dung tích&nbsp;:</font></b></td>
							<td align="right"><font><?php echo $product->capacity?> ml</font></td>
						</tr><tr>
							<td><b><font>Màu sắc&nbsp;:</font></b></td>
							<td align="right"><font><?php echo $product->color?></font></td>
						</tr>
						</table>
					</div>
				</div>
			</li>
		</ul>
		<ul><li class="prods_hseparator first last"><img width="1" height="1" alt="" src="<?php echo URL::site('contents/front/images/spacer.gif')?>"></li></ul>
		<?php }?>
	<?php }?>
<?php }?>

</div>  </div>
</div>


<div class="result result2_top"><div class="result2_bottom"><div class="cl_both result_bottom_padd ofh">
        	<div class="fl_left result_left"><span>Hiển thị <strong><?php echo $pagination->current_first_item?></strong> đến <strong><?php echo $pagination->current_last_item?></strong></span> (của <strong><?php echo $pagination->total_items?></strong> sản phẩm)</div>
            <div class="fl_right result_right">Trang: &nbsp;<?php echo ($pagination->total_pages > 1) ? $pagination : 1?>&nbsp;</div>
</div></div></div>

<script type="text/javascript">
/*<![CDATA[*/
	jQuery(document).ready(function(){ 			
		 var row_list = jQuery('.row');
		 row_list.each(function(){
			 new equalHeights(jQuery('#' + jQuery(this).attr("id")));
		  });	
	})
/*]]>*/
</script>