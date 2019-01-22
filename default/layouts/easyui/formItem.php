<tr>
	<td>{prop label}{prop text}</td>
	<td>
	<?php if (@$data->type == 'user-defined') { ?>
		{children all}
	<?php } else { ?>
	<input {attr type} {attr name} {attr value} {attr onclick} {ifprop validatebox=true}class="easyui-validatebox"{/if} {attr required}>
	<?php } ?>
	</td>
</tr>