<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#lnk_change").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			window.location = '<?php echo URL::site('admin');?>';
		});

		jQuery("#adminForm").validate({
			rules: {
				current_password: "required",
				new_password: "required",
				verify_password: {
					equalTo: "#new_password"
				}
			},
			messages: {
				current_password: "Vui lòng nhập mật khẩu hiện thời",
				new_password: "Vui lòng nhập mật khẩu mới",
				verify_password: {
					equalTo: "Mật khẩu gõ lại không khớp"
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
					<a href="javascript:;//Thay đổi" id="lnk_change" class="toolbar">
						<span class="icon-32-save" title="Thay đổi"></span>
						Thay đổi
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
				<div class="header icon-48-user">Đổi mật khẩu</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/user/save_password');?>" method="post" name="adminForm" id="adminForm">
					<div class="col width-100">
						<fieldset class="adminform">
						<legend>Đổi mật khẩu</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('current_password', 'Mật khẩu hiện thời'); ?>
							</td>
							<td>
								<input class="inputbox" type="password" name="current_password" id="current_password" size="40" value="" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('new_password', 'Mật khẩu mới'); ?>
							</td>
							<td>
								<input class="inputbox" type="password" name="new_password" id="new_password" size="40" value="" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('verify_password', 'Gõ lại mật khẩu'); ?>
							</td>
							<td>
								<input class="inputbox" type="password" name="verify_password" id="verify_password" size="40" value="" />
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('user_name', Auth::instance()->get_user()->user_name, array('id'=>'user_name',));?>
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
