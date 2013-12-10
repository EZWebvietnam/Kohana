<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php echo HTML::tinymce('description', array('document_base_url' => URL::base()), false)?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#sort_order").inputInteger();
		
		jQuery("#lnk_save").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			<?php if((int) $news_category_pagination > 1){?>
			window.location = '<?php echo url::site('admin/news_category/'.$news_category_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo url::site('admin/news_category');?>';
			<?php }?>
		});

		jQuery("#adminForm").validate({
			rules: {
				name: "required",
				city_id: "required",
			},
			messages: {
				name: 'Vui lòng nhập tên chuyên mục'
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
					</td>
				</tr>
				</table>
				</div>
				<div class="header icon-48-thememanager">Quản lý chuyên mục tin</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/news_category/save');?>" method="post" name="adminForm" id="adminForm" autocomplete="off">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết chuyên mục tin</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('name', 'Tên chuyên mục');?>
							</td>
							<td>
								<?php
									echo Form::input('name', $news_category->name, array(
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
									echo Form::input('sort_order', $news_category->sort_order, array(
												'id' => 'sort_order',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						</table>
						</fieldset>
						<fieldset class="adminform" width="100%">
						<legend>Mổ tả</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td>
								<textarea name="description" id="description" rows="8" cols="45"><?php echo $news_category->description?></textarea>
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
								echo Form::textarea('page_title', $news_category->page_title, array(
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
								echo Form::textarea('meta_keywords', $news_category->meta_keywords, array(
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
								echo Form::textarea('meta_description', $news_category->meta_description, array(
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
					<div class="clr"></div>
					<?php echo Form::hidden('id', $news_category->id, array('id'=>'id',));?>
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
