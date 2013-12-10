<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="infoBoxWrapper list"><div class="box_wrapper">
	<div class="infoBoxHeading"><div class="title-icon"></div>Danh mục</div>
	<div class="infoBoxContents">
		<?php if(isset($categories) AND count($categories) > 0){?>
		<ul class="categories">
			<?php foreach($categories as $category){?>
				<li>
					<?php echo Utils::repeat_text('<div class="div">', $category->level)?>
					<a href="<?php echo URL::site('category/' . $category->id . '_' . $category->friendly_url)?>">
					<?php if($list_selected_id->contains($category->id)){?>
						<b><?php echo $category->name?></b>
					<?php }else{?>
						<?php echo $category->name?>
					<?php }?>
					<?php if($category->have_children()){?>
						<span class="category_arrow"></span>
					<?php }?>
					</a>
					<?php echo Utils::repeat_text('</div>', $category->level)?>
				</li>
			<?php }?>
		</ul>
		<?php }?>
	</div>
</div></div>
