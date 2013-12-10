<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="title-t"><div class="title-icon"></div><h1>Sản Phẩm Đặc Biệt</h1></div>
<div class="result result1_top"><div class="result1_bottom">
	<div class="cl_both result_top_padd ofh">
		<div class="fl_left result_left"><span>Hiển thị <strong><?php echo $pagination->current_first_item?></strong> đến <strong><?php echo $pagination->current_last_item?></strong></span> (của <strong><?php echo $pagination->total_items?></strong> sản phẩm)</div>
		<div class="fl_right result_right">Trang: &nbsp;<?php echo ($pagination->total_pages > 1) ? $pagination : 1?>&nbsp;</div>
	</div>
</div></div>

<div class="contentContainer">
<?php if(isset($products) AND count($products) > 0){?>
	<div class="contentPadd"><div class="padding un prods_table">
	<?php foreach($products as $key => $product){?>
		<?php
			$product_url = URL::site('product/' . $product->id . '_' . $product->friendly_url);
			$product_price = (float) $product->price / (float) $currency->rate;
		?>
		<div align="center" class="contentInfoBlock" valign="top"><div class="prods_content decks"><div class="forecastle">
			<ol class="masthead">
				<li class="port_side">
				<div style="width:167px;height:142px;" class="pic_padd wrapper_pic_div">
				<a style="width:167px;height:142px;" href="<?php echo $product_url?>" class="prods_pic_bg"><img width="165" height="140" style="width:167px;height:142px;margin:0px 0px 0px 0px;" title="<?php echo $product->name?>" alt="<?php echo $product->name?>" src="<?php echo URL::site('upload/product/thumbs/' . $product->thumb_image)?>">
					<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
						<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
							<div class="wrapper_pic_bl"><div style="width:167px;height:142px;" class="wrapper_pic_br"></div></div>
						</div></div></div>
					</div></div></div>
				</a>
				</div>
				</li>
				<li class="starboard_side">
					<div class="info">
						<h2 class="name name2_padd"><span class="name"><a href="<?php echo $product_url?>"><?php echo $product->name?></a></span></h2>
						<div class="manuf manuf_padd"><span>Nồng độ:</span> <?php echo $product->alcohol_level?> %</div>
						<div class="manuf manuf_padd"><span>Dung tích:</span> capacity<?php echo $product->capacity?> ml</div>
						<div class="manuf manuf_padd"><span>Xuất xứ:</span> <?php echo $product->origin->name?></div>
						<div class="manuf manuf_padd"><span>Màu sắc:</span> <?php echo $product->color?></div>
						<h2 class="price price2_padd"><b></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp; <?php echo round($product_price)?> <?php echo $currency->symbol?></span></h2>
						<div class="desc desc2_padd"><?php echo $product->sort_description?></div>
						<div class="button button2__padd">
							<div onmouseover="this.className='bg_button2-act';" onmouseout="this.className='bg_button2';" class="bg_button2"><div class="button-tl"><div class="button-tr"><div class="button-t">
							<a role="button" href="<?php echo $product_url?>" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" id="tdb1">
							<span class="ui-button-icon-primary ui-icon ui-icon-cart"></span>
							<span class="ui-button-text">Xem&nbsp;Chi&nbsp;Tiết</span></a>
							</div></div></div></div>
						</div>
					</div>
				</li>
			</ol>
		</div></div></div>
		<div class="prods_hseparator"><img width="1" height="1" alt="" src="images/spacer.gif"></div>
	<?php }?>
	</div></div>
<?php }?>
</div>
<div class="result result2_top"><div class="result2_bottom">
	<div class="cl_both result_bottom_padd ofh">
		<div class="fl_left result_left"><span>Hiển thị <strong><?php echo $pagination->current_first_item?></strong> đến <strong><?php echo $pagination->current_last_item?></strong></span> (của <strong><?php echo $pagination->total_items?></strong> sản phẩm)</div>
		<div class="fl_right result_right">Trang: &nbsp;<?php echo ($pagination->total_pages > 1) ? $pagination : 1?>&nbsp;</div>
	</div>
</div></div>