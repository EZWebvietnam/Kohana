<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div class="title-t"><div class="title-icon"></div><h1>Liên Hệ</h1></div>
<style type="text/css">
	form label.error, form label.invalid_captcha{
		color: red;
		font-style: italic;
		font-size: 1.0em;
		font-weight: normal;
	}
</style>
<?php echo Form::open('contact', array('method' => 'post', 'name' => 'contact_us', 'id' => 'contact_us')) ?>
<div class="contentContainer"><div class="contentPadd txtPage">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="fieldKey"><div class="crosspiece95"></div><?php echo Form::label('name', 'Họ tên');?>:</td>
		<td width="100%" class="fieldValue">
		<?php
			echo Form::input('name', $contact->name, array(
						'id' => 'name',
						'class' => 'input',
					));
		?>
		</td>
	</tr>
	<tr>
		<td class="fieldKey"><div class="crosspiece95"></div><?php echo Form::label('email', 'Địa chỉ email');?>:</td>
		<td width="100%" class="fieldValue">
		<?php
			echo Form::input('email', $contact->email, array(
						'id' => 'email',
						'class' => 'input',
					));
		?>
		</td>
	</tr>
	<tr>
		<td class="fieldKey"><div class="crosspiece95"></div><?php echo Form::label('telephone', 'Số điện thoại');?>:</td>
		<td width="100%" class="fieldValue">
		<?php
			echo Form::input('telephone', $contact->telephone, array(
						'id' => 'telephone',
						'class' => 'input',
					));
		?>
		</td>
	</tr>
	<tr>
		<td class="fieldKey"><div class="crosspiece95"></div><?php echo Form::label('address', 'Địa chỉ');?>:</td>
		<td width="100%" class="fieldValue">
		<?php
			echo Form::input('address', $contact->address, array(
						'id' => 'address',
						'class' => 'input',
					));
		?>
		</td>
	</tr>
	<tr>
		<td class="fieldKey"><div class="crosspiece95"></div><?php echo Form::label('subject', 'Chủ đề');?>:</td>
		<td width="100%" class="fieldValue">
		<?php
			echo Form::input('subject', $contact->subject, array(
						'id' => 'subject',
						'class' => 'input',
					));
		?>
		</td>
	</tr>
	<tr>
		<td valign="top" class="fieldKey"><?php echo Form::label('content', 'Nội dung');?>:</td>
		<td class="fieldValue">
		<?php
			echo Form::textarea('content', $contact->content, array(
						'id' => 'content',
						'rows' => '15',
						'cols' => '50',
						'wrap' => 'soft',
					));
		?>
		</td>
	</tr>
	<tr>
		<td valign="top" class="fieldKey"><?php echo Form::label('captcha', 'Mã xác nhận');?>:</td>
		<td class="fieldValue">
		<?php
			echo Form::input('captcha', '', array(
						'id' => 'captcha',
						'size' => '15',
					));
		?>
		<?php if(isset($invalid_captcha)){?>
			<label class="error" for="captcha">Mã xác nhận không hợp lệ</label>
		<?php }?>
		<br />
		<span id="refresh_captcha" style="cursor:pointer;"><img src="<?php echo URL::site('captcha/default')?>" id="img_captcha" style="width:100px;height:25px;margin-top:3px;" alt="Captcha" class="inputbox" align="absmiddle" border="0" /></span>
		</td>
	</tr>
	</table>
	<div class="buttonSet">
		<span class="fl_right">
		<div onmouseover="this.className='bg_button2-act';" onmouseout="this.className='bg_button2';" class="bg_button2"><div class="button-tl"><div class="button-tr"><div class="button-t">
		<span class="">
			<button type="submit" id="tdb1" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-primary" role="button" aria-disabled="false">
				<span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-e"></span><span class="ui-button-text">Gửi liên hệ</span>
			</button>
		</span>
		</div></div></div></div>
		</span>
	</div>
</div></div>
<?php echo Form::hidden('secret_key', $secret_key, array('id'=>'secret_key',));?>
<?php echo Form::close() ?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery("#tdb1").button({icons:{primary:"ui-icon-triangle-1-e"}}).addClass("ui-priority-primary").parent().removeClass("tdbLink");
	jQuery(function() {
		jQuery("#sort_order").inputInteger();
		jQuery("#rate").inputFloat();

		jQuery('#refresh_captcha').click(function(){
			var objDate = new Date();
			jQuery('#img_captcha').get(0).src = '<?php echo URL::site('captcha/default')?>?code=' + objDate.getMilliseconds();
		});

		jQuery("#contact_us").validate({
			rules: {
				name: 'required',
				email: {
					required: true,
					email: true
				},
				telephone: 'required',
				subject: 'required',
				captcha: 'required'
			},
			messages: {
				name: '<br />Vui lòng nhập tên',
				email: {
					required: '<br />Vui lòng nhập địa chỉ email',
					email: '<br />Địa chỉ email không hợp lệ'
				},
				telephone: '<br />Vui lòng nhập số điện thoại',
				subject: '<br />Vui lòng nhập chủ đề', 
				captcha: 'Vui lòng mã xác nhận'
			}
		});
	});
/*]]>*/
</script>
