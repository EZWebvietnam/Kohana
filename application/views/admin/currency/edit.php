<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="javascript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#sort_order").inputInteger();
		jQuery("#rate").inputFloat();
		
		jQuery("#lnk_save").click(function(){
			jQuery('#adminForm').submit();
		});

		jQuery("#lnk_close").click(function(){
			<?php if((int) $currency_pagination > 1){?>
			window.location = '<?php echo url::site('admin/currency/'.$currency_pagination);?>';
			<?php }else{?>
			window.location = '<?php echo url::site('admin/currency');?>';
			<?php }?>
		});

		jQuery("#adminForm").validate({
			rules: {
				name: "required"
			},
			messages: {
				name: 'Vui lòng nhập tên tiền tệ'
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
				<div class="header icon-48-thememanager">Quản lý tiền tệ</div>
				<div class="clr"></div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
				<form action="<?php echo URL::site('admin/currency/save');?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" autocomplete="off">
					<div class="col width-50">
						<fieldset class="adminform">
						<legend>Chi tiết tiền tệ</legend>
						<table class="admintable" cellspacing="1">
						<tr>
							<td class="key">
								<?php echo Form::label('name', 'Tên tiền tệ');?>
							</td>
							<td>
								<?php
									echo Form::input('name', $currency->name, array(
												'id' => 'name',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('short_name', 'Tên ngắn');?>
							</td>
							<td>
								<?php
									echo Form::input('short_name', $currency->short_name, array(
												'id' => 'short_name',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('symbol', 'Ký hiệu');?>
							</td>
							<td>
								<?php
									echo Form::input('symbol', $currency->symbol, array(
												'id' => 'symbol',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<?php echo Form::label('rate', 'Tỷ giá');?>
							</td>
							<td>
								<?php
									echo Form::input('rate', $currency->rate, array(
												'id' => 'rate',
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
									echo Form::input('sort_order', $currency->sort_order, array(
												'id' => 'sort_order',
												'class' => 'inputbox',
												'size' => '40',
											));
								?>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>
					<div class="clr"></div>
					<?php echo Form::hidden('id', $currency->id, array('id'=>'id',));?>
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
