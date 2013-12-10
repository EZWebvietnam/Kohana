<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="infoBoxWrapper box3 case"><div class="box_wrapper">
	<div class="infoBoxHeading"><div class="title-icon"></div>Xuất xứ</div>
	<div class="infoBoxContents">
		<select name="cb_origin_id" id="cb_origin_id" size="1" class="select">
			<option value="">Vui lòng chọn</option>
			<?php foreach($origins as $origin){?>
			<option value="<?php echo URL::site('origin/' . $origin->id . '_' . Utils::url_lize($origin->name))?>" <?php echo ((int) $origin->id == (int) $origin_id) ? 'selected' : '';?>><?php echo $origin->name?></option>
			<?php }?>
		</select>
	</div>
</div></div>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#cb_origin_id").change(function(){
			if(this.value.length > 0){
				window.location = this.value;
			}
		});
	});
/*]]>*/
</script>
