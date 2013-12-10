<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="row_3"><div class="container_60 ofh"><div class="grid_60">
	<div class="breadcrumb">&nbsp;&nbsp;
	<?php $count = 0; $length = count($breadcrumb);?>
	<?php foreach($breadcrumb as $item){?>
		<?php $count++;?>
		<a class="headerNavigation" href="<?php echo $item->url?>"><?php echo $item->name?></a>
		<?php if($count < $length){?>
			»
		<?php }?>
	<?php }?>
	</div>
</div></div></div>