<?php
$permission = pzk_element('permission');
$controllers = $permission->getAllControllers();
$types = $permission->getAllUserTypes();
$statuses = _db()->select('*')->from('profile_controller_permission')->result();
?>
<table border="1" style="border-collapse: collapse;">
	<tr>
		<th>Controller</th><th>Action</th>{each $types as $type}<th>{type}</th>{/each}
	</tr>
	{each $controllers as $controller}
		{? $controllerName = $controller['controller']; $actions = $controller['actions']; ?}
	{each $actions as $action}
	<tr>
		<td>{controllerName}</td><td>{action}</td>{each $types as $type}<td>
			{ifvar type=Administrator}
				Yes
			{else}
				<select id="permission_{type}_{controllerName}_{action}"
						onchange="submitPermission('{type}','{controllerName}', '{action}', this.value)">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			{/if}
			
		</td>{/each}
	</tr>
	{/each}
	{/each}
</table>
<script type="text/javascript">
function submitPermission(type, controller, action, status) {
	$.ajax({
		type: 'post',
		method: 'post',
		url: BASE_URL + '/index.php/Dtable/replace?table=profile_controller_permission',
		data: {type: type, controller: controller, action: action, status: status},
		success: function(result) {
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}
		}
	});
}
var statuses = <?php echo json_encode($statuses)?>;
setTimeout(function(){
	$(document).ready(function(e) {
		for(var i=0; i < statuses.length; i++) {
			
			var controller = statuses[i]['controller'];
			var action = statuses[i]['action'];
			var type = statuses[i]['type'];
			var status = statuses[i]['status'];
			$('#permission_' + type + '_' + controller + '_' + action).val(status);
		}
	});
}, 1000);
</script>