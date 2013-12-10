<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="menu ofh">
<?php if(isset($menu_items) AND count($menu_items) > 0){
	$items = array();
	foreach($menu_items as $item)
	{
		$items[] = $item;
	}
	$items = array_reverse($items);
?>
	<!-- menu cart END-->
	<ul>
	<?php
	foreach($items as $item){
		$params = $item->params();
	?>
		<li class="menu_item" onclick="document.location='<?php echo URL::site($params->url_name)?>'">
		<div class="part-tl"><div class="part-tr"><div class="part-t">
			<span><a href="<?php echo URL::site($params->url_name)?>"><?php echo $item->name?></a></span>
		</div></div></div>
		</li>
	<?php }?>
	</ul>
	<!-- menu cart END-->
<?php }?>
</div>
