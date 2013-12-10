<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#lnk_save").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			<?php if((int) $user_pagination > 1){?>
			window.location = '<?php echo URL::site('admin/user/'.$user_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo URL::site('admin/user');?>';
			<?php }?>
		});

		jQuery("#adminForm").validate({
			rules: {
				full_name: "required",
				user_name: "required",
				verify_password: {
					equalTo: "#password"
				}
			},
			messages: {
				full_name: "Vui lòng nhập tên đầy đủ",
				user_name: "Vui lòng nhập tên truy cập",
				verify_password: {
					equalTo: "Mật khẩu không khớp"
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
					</td>
				</tr>
				</table>
				</div>
				<div class="header icon-48-user">Quản lý người dùng</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/user/save');?>" method="post" name="adminForm" id="adminForm" autocomplete="off">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết người dùng</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td width="150" class="key">
								<?php echo Form::label('full_name', 'Tên đầy đủ'); ?>
							</td>
							<td>
								<?php
									echo Form::input('full_name', $user->full_name, array(
												'id' => 'full_name',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('user_name', 'Tên truy cập'); ?>
							</td>
							<td>
							<?php
								if(!empty($user->user_name)){
									echo Form::input('user_name', $user->user_name, array(
												'id' => 'user_name',
												'class' => 'inputbox',
												'size' => '40',
												'readonly' => 'readonly',
											));
								}else{
									echo Form::input('user_name', '', array(
												'id' => 'user_name',
												'class' => 'inputbox',
												'size' => '40',
											));
								}
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('email', 'Email'); ?>
							</td>
							<td>
								<?php
									echo Form::input('email', $user->email, array(
												'id' => 'email',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('password', 'Mật khẩu mới'); ?>
							</td>
							<td>
								<?php
									echo Form::password('password', '', array(
												'id' => 'password',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('verify_password', 'Gõ lại mật khẩu'); ?>
							</td>
							<td>
								<?php
									echo Form::password('verify_password', '', array(
												'id' => 'verify_password',
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
						<legend>Chi tiết người dùng</legend>
						<table width="100%" class="paramlist admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('tel', 'Số điện thoại'); ?>
							</td>
							<td>
								<?php
									echo Form::input('tel', $user->tel, array(
												'id' => 'tel',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('mobile', 'Số di động'); ?>
							</td>
							<td>
								<?php
									echo Form::input('mobile', $user->mobile, array(
												'id' => 'mobile',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('user_status', 'Trạng thái'); ?>
							</td>
							<td>
								<?php
									echo Form::checkbox('user_status', '1', ((int) $user->status != 0), array(
												'id' => 'user_status',
											));
								?>
								Hoạt động
							</td>
						</tr>
						<tr>
							<td class="key">Thời gian tạo</td>
							<td><?php echo date('Y/m/d H:i:s', (int) $user->created)?></td>
						</tr>
						<tr>
							<td class="key">Đăng nhập lúc cuối</td>
							<td><?php echo date('Y/m/d H:i:s', (int) $user->last_login)?></td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('id', $user->id, array('id'=>'id',));?>
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
