<div class="form-item">
	<div>{prop label}{prop text}</div>
	<div>
	<?php if (@$data->type == 'user-defined') { ?>
		{children all}
	<?php } else { ?>
	<input {attr type} {attr name} {attr value} {attr onclick} {ifprop validatebox=true}class="easyui-validatebox"{/if} {attr required}>
	<?php } ?>
	</div>
</div>