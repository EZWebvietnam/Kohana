<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
	echo HTML::tinymce('description',
			array(
				'document_base_url' => URL::base(),
				'width' => '600px',
				'height' => '250px',
			)
		, false)
?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#price").inputInteger();
		jQuery("#capacity").inputInteger();
		jQuery("#alcohol_level").inputInteger();
		jQuery("#production_year").mask('9999');
		
		jQuery("#lnk_save").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			<?php if(isset($product_pagination) && (int) $product_pagination > 1){?>
			window.location = '<?php echo url::site('admin/product/'.$product_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo url::site('admin/product');?>';
			<?php }?>
		});

		jQuery("#adminForm").validate({
			rules: {
				sku: 'required',
				name: 'required',
				price: 'required',
				alcohol_level: {
					required: true,
					max: 100
				}
			},
			messages: {
				sku: 'Vui lòng nhập mã sản phẩm',
				name: 'Vui lòng nhập tên sản phẩm',
				price: 'Vui lòng nhập giá sản phẩm',
				alcohol_level: {
					required: 'Vui lòng nhập nồng độ cồn.', 
					max: 'Vui lòng nhập một giá trị nhỏ hơn 100.'
				}
			}
		});
	});
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
				</tr>
				</table>
				</div>
				<div class="header icon-48-thememanager">Quản lý sản phẩm</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/product/save');?>" method="post" name="adminForm" id="adminForm"  enctype="multipart/form-data">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết sản phẩm</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('product_category_id', 'Danh mục sản phẩm');?>
							</td>
							<td>
							<?php
								echo Form::select('product_category_id', Arr::merge(array('-- Chọn danh mục --'), $product_categories), $product->product_category->id, array(
											'id' => 'product_category_id',
											'class' => 'inputbox',
											'style' => 'width: 200px;',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('manufacturer_id', 'Hãng sản xuất');?>
							</td>
							<td>
							<?php
								echo Form::select('manufacturer_id', Arr::merge(array('-- Chọn hãng sản xuất --'), $product_manufacturers), $product->manufacturer->id, array(
											'id' => 'manufacturer_id',
											'style' => 'width: 200px;',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('origin_id', 'Xuất xứ');?>
							</td>
							<td>
							<?php
								echo Form::select('origin_id', Arr::merge(array('-- Chọn xuất xứ --'), $product_origins), $product->origin->id, array(
											'id' => 'origin_id',
											'style' => 'width: 200px;',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('sku', 'Mã sản phẩm');?>
							</td>
							<td>
								<?php
									echo Form::input('sku', $product->sku, array(
												'id' => 'sku',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('name', 'Tên sản phẩm');?>
							</td>
							<td>
								<?php
									echo Form::input('name', $product->name, array(
												'id' => 'name',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('image', 'Hình ảnh');?>
							</td>
							<td>
								<?php
									echo Form::file('image', array(
												'id' => 'image',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('price', 'Giá');?>
							</td>
							<td>
								<?php
									echo Form::input('price', $product->price, array(
												'id' => 'price',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('special', 'Sản phẩm đăc biệt'); ?>
							</td>
							<td>
								<?php
									echo Form::checkbox('special', '1', ((int) $product->special != 0), array(
												'id' => 'special',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('capacity', 'Dung tích');?>
							</td>
							<td>
								<?php
									echo Form::input('capacity', $product->capacity, array(
												'id' => 'capacity',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('alcohol_level', 'Nồng độ cồn');?>
							</td>
							<td>
								<?php
									echo Form::input('alcohol_level', $product->alcohol_level, array(
												'id' => 'alcohol_level',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('color', 'Màu sắc');?>
							</td>
							<td>
								<?php
									echo Form::input('color', $product->color, array(
												'id' => 'color',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('production_year', 'Năm sản xuất');?>
							</td>
							<td>
								<?php
									echo Form::input('production_year', $product->production_year, array(
												'id' => 'production_year',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Siêu dữ liệu</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('page_title', 'Tiêu đề trang');?>
							</td>
							<td>
							<?php
								echo Form::textarea('page_title', $product->page_title, array(
											'id' => 'page_title',
											'rows' => '5',
											'cols' => '45',
										));
							?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<?php echo Form::label('meta_keywords', 'Meta keyword');?>
							</td>
							<td>
							<?php
								echo Form::textarea('meta_keywords', $product->meta_keywords, array(
											'id' => 'meta_keywords',
											'rows' => '5',
											'cols' => '45',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('meta_description', 'Meta description');?>
							</td>
							<td>
							<?php
								echo Form::textarea('meta_description', $product->meta_description, array(
											'id' => 'meta_description',
											'rows' => '5',
											'cols' => '45',
										));
							?>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="col width-100">
						<fieldset class="adminform" width="100%">
						<legend>Mô tả</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('sort_description', 'Mô tả ngắn');?>
							</td>
							<td>
							<?php
								echo Form::textarea('sort_description', $product->sort_description, array(
											'id' => 'sort_description',
											'rows' => '5',
											'style' => 'width: 600px;',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('description', 'Mô tả');?>
							</td>
							<td>
								<textarea name="description" id="description" rows="8" style="width: 600px;"><?php echo $product->description?></textarea>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('id', $product->id, array('id'=>'id',));?>
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
