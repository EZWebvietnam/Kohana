<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
	echo HTML::tinymce('content',
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
		jQuery("#lnk_save").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			<?php if(isset($news_content_pagination) && (int) $news_content_pagination > 1){?>
			window.location = '<?php echo url::site('admin/news_content/'.$news_content_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo url::site('admin/news_content');?>';
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
				sku: 'Vui lòng nhập mã nội dung tin',
				name: 'Vui lòng nhập tên nội dung tin',
				price: 'Vui lòng nhập giá nội dung tin',
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
				<div class="header icon-48-thememanager">Quản lý nội dung tin</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/news_content/save');?>" method="post" name="adminForm" id="adminForm"  enctype="multipart/form-data">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết nội dung tin</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('news_category_id', 'Danh mục tin');?>
							</td>
							<td>
							<?php
								echo Form::select('news_category_id', Arr::merge(array('-- Chọn danh mục --'), $news_categories), $news_content->news_category->id, array(
											'id' => 'news_category_id',
											'class' => 'inputbox',
											'style' => 'width: 300px;',
										));
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('name', 'Tên nội dung tin');?>
							</td>
							<td>
								<?php
									echo Form::input('name', $news_content->name, array(
												'id' => 'name',
												'class' => 'inputbox',
												'size' => '40',
												'style' => 'width: 300px;',
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
												'size' => '45',
												'style' => 'width: 300px;',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('intro_text', 'Nội dung vắn tắt');?>
							</td>
							<td>
							<?php
								echo Form::textarea('intro_text', $news_content->intro_text, array(
											'id' => 'intro_text',
											'rows' => '13',
											'style' => 'width: 300px;',
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
								echo Form::textarea('page_title', $news_content->page_title, array(
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
								echo Form::textarea('meta_keywords', $news_content->meta_keywords, array(
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
								echo Form::textarea('meta_description', $news_content->meta_description, array(
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
						<legend>Nội dung</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td>
								<textarea name="content" id="content" rows="8" style="width: 600px;"><?php echo $news_content->content?></textarea>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('id', $news_content->id, array('id'=>'id',));?>
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
