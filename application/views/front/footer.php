<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="grid_60 footer_menu footer">
	<div class="Footer_BoxWrapper">
	<h4 class="Footer_BoxHeading"></h4>
<?php if(isset($menu_items) AND count($menu_items) > 0){?>
	<ul>
	<?php
	foreach($menu_items as $item){
		$params = $item->params();
	?>
		<li class=""><a href="<?php echo URL::site($params->url_name)?>"><?php echo $item->name?></a></a></li>
	<?php }?>
	</ul>
<?php }?>
	</div>    
	<p>Bản quyền &copy; 2011 <?php echo HTML::anchor('', 'Presente') ?><!-- {%FOOTER_LINK} --> </p>
</div>
