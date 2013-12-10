<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#lnk_save").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			<?php if((int) $contact_pagination > 1){?>
			window.location = '<?php echo url::site('admin/contact/'.$contact_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo url::site('admin/contact');?>';
			<?php }?>
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
				<div class="header icon-48-thememanager">Quản lý liên hệ</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/contact/save');?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" autocomplete="off">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết liên hệ</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">Tên liên hệ</td>
							<td><?php echo $contact->name?></td>
						</tr>
						<tr>
							<td class="key">Email</td>
							<td><?php echo $contact->email?></td>
						</tr>
						<tr>
							<td class="key">Điện thoại</td>
							<td><?php echo $contact->telephone?></td>
						</tr>
						<tr>
							<td class="key">Địa chỉ</td>
							<td><?php echo $contact->address?></td>
						</tr>
						<tr>
							<td class="key">Chủ đề</td>
							<td><?php echo $contact->subject?></td>
						</tr>
						<tr>
							<td class="key">Nội dung</td>
							<td><?php echo $contact->content?></td>
						</tr>
						<tr>
							<td class="key">Nội dung</td>
							<td><?php echo $contact->content?></td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('status', 'Trạng thái'); ?>
							</td>
							<td>
								<?php
									echo Form::checkbox('status', '1', ((int) $contact->status != 0), array(
												'id' => 'status',
											));
								?>
								Đã xử lý
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('id', $contact->id, array('id'=>'id',));?>
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
