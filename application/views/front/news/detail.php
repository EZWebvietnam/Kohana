<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="contentContainer page_un"><div class="contentPadd">
	<div class="prods_info decks"><div class="forecastle">
		<ol class="masthead">
			<li class="starboard_side">
			<div class="info">
				<h2><?php echo $content->name?></h2>
			</div>   
			</li>
		</ol>
	</div></div>
	<div class="grid_"><div class="contentInfoText un prods_info extra marg-bottom">
		<div class="data data_add"><span>Ngày đăng tin:</span> <?php echo date('d/m/Y', (int) $content->date_created)?></div>
		<div class="desc desc_padd"><?php echo Utils::decode_data($content->content)?></span></div>
	</div></div>
</div></div>