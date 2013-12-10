<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#lnk_back").click(function(){
			<?php if((int) $product_pagination > 1){?>
			window.location = '<?php echo URL::site('admin/product/'.$product_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo URL::site('admin/product');?>';
			<?php }?>
		});

		jQuery("#lnk_save").click(function(){
			jQuery('#image_upload').uploadifyUpload();
		});

		jQuery("#lnk_delete").click(function(){
			if(confirm('Bạn có chắc chắn muốn xóa hình ảnh đã chọn?')){
				var form = document.adminForm;
				form.action = '<?php echo URL::site('admin/product_image/delete');?>';
				form.submit();
			}
		});

		jQuery('#image_upload').uploadify({ 
			'uploader'		:	'<?php echo URL::base()?>scripts/jquery-uploadify/uploadify.swf', 
			'script'		:	'<?php echo URL::site('upload_image/product')?>', 
			'cancelImg'		:	'<?php echo URL::base()?>scripts/jquery-uploadify/cancel.png',
			'multi'			:	true,
			'queueID'		:	'queue_files',
			//'fileExt'		:	'*.gif;*.jpg;*.jpeg;*.png;*.bmp',
			'scriptData'	:	{
									'product_id':'<?php echo $product->id; ?>',
									'secret_key':'<?php echo Crypto_Hash_Simple::compute_hash(Kohana::$config->load('upload.secret_key')); ?>'
								},
			'fileDataName'	:	'image_upload',
			'onAllComplete'	:	function(){
				window.location = window.location;
			}
		});

		jQuery('#td_list_image a:has(img)').lightBox(
			{
				imageLoading: '<?php echo URL::base()?>scripts/jquery-lightbox/images/lightbox-ico-loading.gif',
				imageBtnPrev: '<?php echo URL::base()?>scripts/jquery-lightbox/images/lightbox-btn-prev.gif',
				imageBtnNext: '<?php echo URL::base()?>scripts/jquery-lightbox/images/lightbox-btn-next.gif',
				imageBtnClose: '<?php echo URL::base()?>scripts/jquery-lightbox/images/lightbox-btn-close.gif',
				imageBlank: '<?php echo URL::base()?>scripts/jquery-lightbox/images/lightbox-blank.gif'
			}
		);
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
				<table class="toolbar" summary="">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="javascript:;//Cập nhật" class="toolbar" id="lnk_save">
							<span class="icon-32-save" title="Cập nhật"></span>
							Cập nhật
						</a>
					</td>
					<td class="button" id="toolbar-back">
						<a href="javascript:;//Quay lại" class="toolbar" id="lnk_back">
							<span class="icon-32-back" title="Quay lại"></span>
							Quay lại
						</a>
					</td>
					<td class="button" id="toolbar-delete">
						<a href="javascript:;//Xóa bỏ" class="toolbar" id="lnk_delete">
							<span class="icon-32-delete" title="Xóa bỏ"></span>
							Xóa bỏ
						</a>
					</td>
				</tr>
				</table>
				</div>
				<div class="header icon-48-cpanel">Quản lý hình ảnh - Sản phẩm <?php echo $product->name?></div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
  		</div>
   		<div class="clr"></div>
		<div id="element-box">
			<div class="t"><div class="t"><div class="t"></div></div></div>
			<div class="m">
			<form action="<?php echo URL::site('admin/product_image/delete/'.$product->id);?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
			<fieldset class="adminform">
				<legend>Tải lên hình ảnh sản phẩm</legend>
				<table class="admintable" cellspacing="1" width="500">
				<tr>
					<td class="key">
						<?php echo Form::label('image_upload', 'Tải lên hình ảnh'); ?>
					</td>
					<td>
						<?php echo Form::file('image_upload', array('id' => 'image_upload'));?>
					</td>
				</tr>
				<tr>
					<td class="key" colspan="2" style="text-align:center;">
						<?php echo Form::label('queue_files', 'Danh sách tập tin'); ?>
					</td>
				</tr>
				<tr>
					<td  colspan="2">
						<div id="queue_files"></div>
					</td>
				</tr>
				</table>
			</fieldset>
			<fieldset class="adminform">
			<legend>Danh sách hình ảnh sản phẩm</legend>
			<table class="adminlist" cellpadding="1" summary="" width="100%">
			<tbody>
				<tr class="row0">
				<td align="center" id="td_list_image">
				<?php foreach($product_images as $images){?>
					<div style="float:left;width:150px;height:170px;">
					<input type="checkbox" name="image_id[]" value="<?php echo $images->id?>" />
					<br />
					<a href="<?php echo URL::base().'upload/product/'.$images->name?>" src="<?php echo URL::base().'upload/product/'.$images->name?>" rel="lightbox-myproduct" title="<?php echo $images->name ?>">
						<img src="<?php echo URL::base().'upload/product/thumbs/'.$images->name?>" alt="<?php echo $images->name?>" />
					</a>
					</div>
				<?php }?>
				</td>
				</tr>
			</tbody>
			</table>
			</fieldset>
			<?php echo Form::hidden('product_id', $product->id, array('id'=>'product_id',));?>
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
