<div class="easyui-accordion" style="width:{prop width};height:{prop height};">
		<?php foreach($data->children as $child) {?>
			<div title="<?php echo @$child->title?>" data-options="iconCls:'icon-<?php echo @$child->icon ?>'" style="overflow:auto;">
				<?php $child->display() ?>
			</div>
		<?php } ?>
	</div>
