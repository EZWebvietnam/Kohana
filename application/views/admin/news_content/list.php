<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
	jQuery(function(){
		jQuery("#lnk_add").click(function(){
			window.location = '<?php echo URL::site('admin/news_content/edit');?>';
		});

		jQuery("#lnk_delete").click(function(){
			var form = document.adminForm;
			if(form.box_checked.value==0){
				alert('Vui lòng chọn nội dung tin để xóa');
			}else if(confirm('Bạn có chắc chắn muốn xóa nội dung tin đã chọn?')){
				form.action = '<?php echo URL::site('admin/news_content/delete');?>';
				form.submit();
			}
		});

		jQuery("#reset_filter").click(function(){
			var form = document.adminForm;
			form.action = '<?php echo URL::site('admin/news_content/reset');?>';
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
							<span class="icon-32-new" title="Thêm mới"></span>
							Thêm mới
						</a>
					</td>
					<td class="button" id="toolbar-delete">
						<a href="javascript:;//Thêm mới" class="toolbar" id="lnk_delete">
							<span class="icon-32-delete" title="Thêm mới"></span>
							Xóa bỏ
						</a>
					</td>
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
			<form action="<?php echo URL::site('admin/news_content');?>" method="post" name="adminForm" id="adminForm">
			<table summary="">
			<tr>
				<td width="100%">
					<?php echo Form::label('news_content_filter', 'Lọc'); ?>:
					<?php
						echo Form::input('news_content_filter', isset($news_content_filter) ? $news_content_filter : '',
								array(
									'id' => 'news_content_filter',
									'class' => 'inputbox',
									'onchange' => 'this.form.submit();',
								)
							);
					?>
					<?php echo Form::button('submit_filter', 'Lọc', array('id' => 'submit_filter'))?>
					<?php echo Form::button('reset_filter', 'Bỏ lọc', array('id' => 'reset_filter'))?>
				</td>
				<td nowrap="nowrap">
					<?php
						echo Form::select('news_category_id', Arr::merge(array('-- Danh mục --'), $news_categories), $news_category_id, array(
									'id' => 'news_category_id',
									'class' => 'inputbox',
									'onchange' => 'this.form.submit();',
								));
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
					<th class="title">
						Tên nội dung tin
					</th>
					<th width="65%" class="title" nowrap="nowrap">
						Nội dung vắn tắt
					</th>
					<th width="5%" class="title" nowrap="nowrap">
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
				<?php foreach($news_contents as $news_content){?>
				<tr class="row0">
					<td align="center"><?php echo $news_content->id?></td>
					<td align="center">
					<?php
						echo Form::checkbox('chk_id[]', $news_content->id, FALSE, array(
									'id' => 'cb' . $news_content->id,
									'class' => 'inputbox',
									'onclick' => 'id_checked(this.checked);',
								));
					?>
					</td>
					<td>
						<a href="<?php echo URL::site('admin/news_content/edit/'.$news_content->id);?>"><?php echo $news_content->name?></a>
					</td>
					<td align="center"><?php echo $news_content->intro_text?></td>
					<td align="center"><?php echo $news_content->id?></td>
				</tr>
				<?php }?>
			</tbody>
			</table>
			<?php echo Form::hidden('box_checked', '0', array('id'=>'box_checked',)); ?>
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
