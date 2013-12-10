<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="infoBoxWrapper box2 info"><div class="box_wrapper">
	<div class="infoBoxHeading">
		<a href="<?php echo URL::site('specials')?>">
			<div class="title-icon"></div>
			Sản phẩm đặc biệt
		</a>
	</div>
	<?php if(isset($products) AND count($products) > 0){?>
	<div class="infoBoxContents">
		<?php foreach($products as $product){
			$product_url = URL::site('product/' . $product->id . '_' . $product->friendly_url);
			$product_price = (float) $product->price / (float) $currency->rate;
		?>
		<div class="pic_padd wrapper_pic_div" style="width:102px;height:87px;">
			<a class="prods_pic_bg" href="<?php echo $product_url?>" style="width:102px;height:87px;"><img src="<?php echo URL::site('upload/product/thumbs/' . $product->thumb_image)?>" alt="<?php echo $product->name?>" title="<?php echo $product->name?>" width="100" height="85"  style="width:102px;height:87px;margin:0px 0px 0px 0px;" />
				<div class="wrapper_pic_t"><div class="wrapper_pic_r"><div class="wrapper_pic_b">
					<div class="wrapper_pic_l"><div class="wrapper_pic_tl"><div class="wrapper_pic_tr">
						<div class="wrapper_pic_bl"><div class="wrapper_pic_br" style="width:102px;height:87px;"></div></div>
					</div></div></div>
				</div></div></div>
			</a>
		</div>
		<div class="box-padd">
			<div class="name name_padd"><span><a href="<?php echo $product_url?>"><?php echo $product->name?></a></span></div>
			<div class="price_padd ofh"><b></b><span class="productSpecialPrice">Giá:&nbsp;&nbsp;<?php echo round($product_price)?> <?php echo $currency->symbol?></span></div>
		</div>
		<br />
		<div class="button__padd">
			<div class="bg_button22" onMouseOut="this.className='bg_button22';" onMouseOver="this.className='bg_button22-act';"><div class="button-tl"><div class="button-tr"><div class="button-t">
				<a href="<?php echo $product_url?>" id="tdb1" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button">
					<span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-e"></span>
					<span class="ui-button-text">Xem chi tiết</span>
				</a>
			</div></div></div></div>
		</div>
		<?php }?>
	</div>
	<?php }?>
</div></div>