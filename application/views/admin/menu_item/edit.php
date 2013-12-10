<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	var item_type = <?php echo (int) $menu_item->item_type?>;
	var params = {
		url_name: '<?php echo $params->url_name?>',
		news_category_id: <?php echo (int) $params->news_category_id?>,
		news_content_id: <?php echo (int) $params->news_content_id?>,
		product_category_id: <?php echo (int) $params->product_category_id?>,
		product_id: <?php echo (int) $params->product_id?>
	}

	jQuery(function(){
		jQuery('#sort_order').inputInteger();
		
		jQuery('#lnk_save').click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery('#lnk_close').click(function(){
			<?php if((int) $menu_item_pagination > 1){?>
			window.location = '<?php echo url::site('admin/menu_item/'.$menu_item_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo url::site('admin/menu_item');?>';
			<?php }?>
		});

		jQuery('#adminForm').validate({
			rules: {
				name: "required",
				city_id: "required",
			},
			messages: {
				name: 'Vui lòng nhập tên menu'
			}
		});
		
		jQuery('#news_category_id').change(function(){
			if(item_type == 2){
				jQuery.getJSON('<?php echo url::site('admin/news_content/populate');?>/' + this.value, function(data){
					options = build_options(data, 0);
					jQuery('#news_content_id').html(options);
				});
			}
		})
		
		jQuery('#product_category_id').change(function(){
			if(item_type == 4){
				jQuery.getJSON('<?php echo url::site('admin/product/populate');?>/' + this.value, function(data){
					options = build_options(data, 0);
					jQuery('#product_id').html(options);
				});
			}
		})
		
		jQuery('.item_type').click(function(){
			item_type = parseInt(this.value);
			switch_item_type(item_type);
		});
		switch_item_type(item_type);
	});

	function switch_item_type(type){
		switch(type){
			case 0:
				disable_all_combobox();
				break;
			case 1:
				disable_all_combobox();
				document.adminForm.news_category_id.disabled = false;

				var news_category_id = parseInt(params.news_category_id);
				jQuery('#news_category_id option').each(function(){
					if(this.value == news_category_id) this.selected = true;
				});
				break;
			case 2:
				disable_all_combobox();
				document.adminForm.news_category_id.disabled = false;
				document.adminForm.news_content_id.disabled = false;

				var news_category_id = parseInt(params.news_category_id);
				jQuery('#news_category_id option').each(function(){
					if(this.value == news_category_id) this.selected = true;
				});
				
				var news_content_id = parseInt(params.news_content_id);
				jQuery.getJSON('<?php echo url::site('admin/news_content/populate');?>/' + news_category_id, function(data){
					options = build_options(data, news_content_id);
					jQuery('#news_content_id').html(options);
				});
				break;
			case 3:
				disable_all_combobox();
				document.adminForm.product_category_id.disabled = false;

				var product_category_id = parseInt(params.product_category_id);
				jQuery('#product_category_id option').each(function(){
					if(this.value == product_category_id) this.selected = true;
				});
				break;
			case 4:
				disable_all_combobox();
				document.adminForm.product_category_id.disabled = false;
				document.adminForm.product_id.disabled = false;

				var product_category_id = parseInt(params.product_category_id);
				jQuery('#product_category_id option').each(function(){
					if(this.value == product_category_id) this.selected = true;
				});
				
				var product_id = parseInt(params.product_id);
				jQuery.getJSON('<?php echo url::site('admin/product/populate');?>/' + product_category_id, function(data){
					options = build_options(data, product_id);
					jQuery('#product_id').html(options);
				});
				break;
		}
	}

	function build_options(object_array, select_id){
		var string_options = '';
		jQuery.each(object_array, function(){
			if(parseInt(this.id) == select_id){
				string_options += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
			}else{
				string_options += '<option value="' + this.id + '">' + this.name + '</option>';
			}
		});
		return string_options;
	}
	
	function disable_all_combobox(){
		jQuery('.combobox').each(function(){
			this.disabled = true;
		});
	}
/*]]>*/
</script>
<div id="content-box">
	<div class="border">
		<div class="padding">
			<div id="toolbar-box">
   			<div class="t"><div class="t"><div class="t"></div></div></div>
			<div class="m">
				<div class="toolbar" id="toolbar">
				<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-save">
					<a href="javascript:;//Cập nhật" id="lnk_save" class="toolbar">
						<span class="icon-32-save" title="Cập nhật"></span>
						Cập nhật
					</a>
					</td>
					<td class="button" id="toolbar-cancel">
					<a href="javascript:;//Hủy bỏ" id="lnk_close" class="toolbar">
						<span class="icon-32-cancel" title="Hủy bỏ"></span>
						Hủy bỏ
					</a>
					</td>
				</tr>
				</table>
				</div>
				<div class="header icon-48-thememanager">Quản lý menu</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/menu_item/save');?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" autocomplete="off">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết menu</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('name', 'Tên menu');?>
							</td>
							<td>
								<?php
									echo Form::input('name', $menu_item->name, array(
												'id' => 'name',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('sort_order', 'Thứ tự');?>
							</td>
							<td>
								<?php
									echo Form::input('sort_order', $menu_item->sort_order, array(
												'id' => 'sort_order',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('item_type', 'Loại menu');?>
							</td>
							<td>
								<?php
									echo Form::radio('item_type', 0,
										((int) $menu_item->item_type == 0),
										array(
											'id' => 'item_type_0',
											'class' => 'item_type',
										)
									);
									echo Form::label('item_type_0', 'Trang tĩnh');
									echo '<br />';

									echo Form::radio('item_type', 1,
										((int) $menu_item->item_type == 1),
										array(
											'id' => 'item_type_1',
											'class' => 'item_type',
										)
									);
									echo Form::label('item_type_1', 'Theo chuyên mục tin');
									echo '<br />';

									echo Form::radio('item_type', 2,
										((int) $menu_item->item_type == 2),
										array(
											'id' => 'item_type_2',
											'class' => 'item_type',
										)
									);
									echo Form::label('item_type_2', 'Theo nội dung tin');
									echo '<br />';

									echo Form::radio('item_type', 3,
										((int) $menu_item->item_type == 3),
										array(
											'id' => 'item_type_3',
											'class' => 'item_type',
										)
									);
									echo Form::label('item_type_3', 'Theo danh mục sản phẩm');
									echo '<br />';

									echo Form::radio('item_type', 4,
										((int) $menu_item->item_type == 4),
										array(
											'id' => 'item_type_4',
											'class' => 'item_type',
										)
									);
									echo Form::label('item_type_4', 'Theo sản phẩm');
									echo '<br />';
								?>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết xuất xứ</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('url_name', 'Url');?>
							</td>
							<td>
								<?php
									echo Form::input('url_name', $params->url_name, array(
												'id' => 'url_name',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('news_category_id', 'Chuyên mục tin');?>
							</td>
							<td>
							<?php
								echo Form::select('news_category_id', Arr::merge(array('-- Chuyên mục tin --'), $news_categories), 0, array(
											'id' => 'news_category_id',
											'class' => 'inputbox combobox',
											'style' => 'width: 200px',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('news_content_id', 'Chuyên mục tin');?>
							</td>
							<td>
							<?php
								echo Form::select('news_content_id', array('-- Nội dung tin --'), 0, array(
											'id' => 'news_content_id',
											'class' => 'inputbox combobox',
											'style' => 'width: 200px',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('product_category_id', 'Danh mục sản phẩm');?>
							</td>
							<td>
							<?php
								echo Form::select('product_category_id', Arr::merge(array('-- Danh mục sản phẩm --'), $product_categories), 0, array(
											'id' => 'product_category_id',
											'class' => 'inputbox combobox',
											'style' => 'width: 200px',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('product_id', 'Sản phẩm');?>
							</td>
							<td>
							<?php
								echo Form::select('product_id', array('-- Sản phẩm --'), 0, array(
											'id' => 'product_id',
											'class' => 'inputbox combobox',
											'style' => 'width: 200px',
										));
							?>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('id', $menu_item->id, array('id'=>'id',));?>
				</form>
				<div class="clr"></div>
				</div>
				<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<noscript>Warning! JavaScript must be enabled for proper operation of the Administrator back-end.</noscript>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
</div>
