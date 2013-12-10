<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#lnk_add").click(function(){
			window.location = '<?php echo URL::site('admin/user/edit');?>';
		});

		jQuery("#lnk_delete").click(function(){
			var form = document.adminForm;
			if(form.box_checked.value==0){
				alert('<?php echo __('Vui lòng chọn người dùng để xóa'); ?>');
			}else if(confirm('<?php echo __('Bạn có chắc chắn muốn xóa người dùng đã chọn?'); ?>')){
				form.action = '<?php echo URL::site('admin/user/delete');?>';
				form.submit();
			}
		});

		jQuery("#reset_filter").click(function(){
			var form = document.adminForm;
			form.action = '<?php echo URL::site('admin/user/reset');?>';
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
				<table class="toolbar" summary="">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="javascript:;//Thêm mới" class="toolbar" id="lnk_add">
							<span class="icon-32-new" title="Thêm mới"></span>Thêm mới
						</a>
					</td>
					<td class="button" id="toolbar-delete">
						<a href="javascript:;//Xóa bỏ" class="toolbar" id="lnk_delete">
							<span class="icon-32-delete" title="Xóa bỏ"></span>Xóa bỏ
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
			<?php
				echo Form::open('admin/user', array(
							'id' => 'adminForm',
							'name' => 'adminForm',
						));
			?>
			<table summary="">
			<tr>
				<td width="100%">
					<?php echo Form::label('user_filter', 'Lọc'); ?>:
					<?php
						echo Form::input('user_filter', isset($user_filter) ? $user_filter : '',
								array(
									'id' => 'user_filter',
									'class' => 'text_area',
									'onchange' => 'this.form.submit();',
								)
							);
					?>
					<?php echo Form::button('submit_filter', 'Lọc', array('id' => 'submit_filter'))?>
					<?php echo Form::button('reset_filter', 'Bỏ lọc', array('id' => 'reset_filter'))?>
				</td>
				<td nowrap="nowrap">
					<?php
						echo Form::select('user_status',
								array(
									'-' => '--Trạng thái--',
									'1' => 'Hoạt động',
									'0' => 'Không hoạt động',
								),
								$user_status,
								array(
									'id' => 'user_status',
									'class' => 'inputbox',
									'onchange' => 'this.form.submit();',
								)
							);
					?>
				</td>
			</tr>
			</table>

			<table class="adminlist" cellpadding="1" summary="">
			<thead>
				<tr>
					<th width="2%" class="title">#</th>
					<th width="3%" class="title">
					<?php echo Form::checkbox('toggle_all', '', FALSE, array('id' => 'toggle_all',));?>
					</th>
					<th class="title">Tên đầy đủ</th>
					<th width="15%" class="title" >Tên truy cập</th>
					<th width="10%" class="title" nowrap="nowrap">Hoạt động</th>
					<th width="15%" class="title">Email</th>
					<th width="10%" class="title">Đăng nhập cuối</th>
					<th width="1%" class="title" nowrap="nowrap">
						ID
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="10">
						<del class="container"><div class="pagination"><div class="limit"><?php echo isset($pagination) ? $pagination : '';?></div><div class="limit"></div></div></del>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($users as $user){?>
				<tr class="row0">
					<td align="center"><?php echo $user->id?></td>
					<td align="center">
					<?php
						echo Form::checkbox('chk_id[]', $user->id, FALSE, array(
									'id' => 'cb' . $user->id,
									'class' => 'inputbox',
									'onclick' => 'id_checked(this.checked);',
								));
					?>
					</td>
					<td>
						<?php echo HTML::anchor('admin/user/edit/'.$user->user_name, $user->full_name);?>
					</td>
					<td><?php echo $user->user_name?></td>
					<td align="center">
					<?php
						if((int)$user->status > 0){
							echo HTML::image('contents/admin/images/tick.png', array(
										'width' => '16',
										'height' => '16',
										'border' => '0',
										'alt' => 'Blocked',
									));
						}
					?>
					</td>
					<td>
						<?php echo HTML::mailto($user->email)?>
					</td>
					<td nowrap="nowrap"><?php echo date('Y/m/d H:i:s', (int) $user->last_login)?></td>
					<td><?php echo $user->id?></td>
				</tr>
				<?php }?>
			</tbody>
			</table>
			<?php echo Form::hidden('box_checked', '0', array('id'=>'box_checked',)); ?>
			<?php echo Form::close(); ?>
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
