<tr>
	<td>{prop label}{prop text}</td>
	<td>
	<?php if (@$data->type == 'user-defined') { ?>
		{children all}
	<?php } else { ?>
	<input placeholder="{prop label}{prop text}" {attr id} {attr type} {attr name} {attr value} {attr onclick} {ifprop validatebox=true}class="easyui-validatebox"{/if} {ifprop required=true}required="required"{/if}>
	<?php } ?>
	</td>
</tr>