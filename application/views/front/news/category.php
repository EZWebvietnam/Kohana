<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="title-t"><div class="title-icon"></div><h1><?php echo $category->name?></h1></div>
<div class="result result1_top"><div class="result1_bottom"><div class="cl_both result_top_padd ofh">
	<div class="fl_left result_left"><span>Hiển thị <strong><?php echo $pagination->current_first_item?></strong> đến <strong><?php echo $pagination->current_last_item?></strong></span> (của <strong><?php echo $pagination->total_items?></strong> bản tin)</div>
	<div class="fl_right result_right">Trang: &nbsp;<?php echo ($pagination->total_pages > 1) ? $pagination : 1?>&nbsp;</div>
</div></div></div>
<div class="contentContainer"><div class="contentPadd">
	<?php foreach($contents as $content){?>
	<?php $news_url = URL::site('content/' . $content->id . '_' . $content->friendly_url);?>
	<div class="contentInfoText un"><div class="prods_info decks"><div class="forecastle">
		<ol class="masthead">
			<li class="port_side">
				<div style="width:167px;height:142px;" class="pic_padd wrapper_pic_div fl_left">
				<a style="width:167px;height:142px;" href="<?php echo $news_url?>" class="prods_pic_bg"><img width="165" height="140" style="width:167px;height:142px;margin:0px 0px 0px 0px;" title="<?php echo $content->name?>" alt="<?php echo $content->name?>" src="<?php echo URL::site('upload/news/thumbs/' . $content->image_path)?>">
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
					<div class="data data_padd"><span>Ngày đăng:</span> <?php echo date('d/m/Y', (int) $content->date_created)?></div>
					<h2 class="name name2_padd"><span><a href="<?php echo $news_url?>"><?php echo $content->name?></a></span> </h2>
					<div class="desc desc_padd add"><?php echo $content->intro_text?></div>
				</div>
			</li>
		</ol>
	</div></div></div>
	<?php }?>
</div></div>
<div class="result result2_top"><div class="result2_bottom"><div class="cl_both result_bottom_padd ofh">
	<div class="fl_left result_left"><span>Hiển thị <strong><?php echo $pagination->current_first_item?></strong> đến <strong><?php echo $pagination->current_last_item?></strong></span> (của <strong><?php echo $pagination->total_items?></strong> bản tin)</div>
	<div class="fl_right result_right">Trang: &nbsp;<?php echo ($pagination->total_pages > 1) ? $pagination : 1?>&nbsp;</div>
</div></div></div>
 