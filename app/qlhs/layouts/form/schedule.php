<form id="scheduleForm">
	<strong>Lịch học: </strong><br />
	<table>
	<tr>
		<td>Ngày bắt đầu:</td>
		<td><input name="startDate" type="date" id="startDate" value="<?php echo date('Y-m-d', time())?>" /></td>
		<td>Ngày kết thúc:</td>
		<td><input name="endDate" id="endDate"  type="date" value="<?php echo date('Y-m-d', time() + 24 * 3600 * 30)?>" /></td>
	</tr>
	<tr>
		<td>Ngày trong tuần:</td>
		<td>
			<select id="weekday" name="weekday">
				<option value="0">Chủ nhật</option>
				<option value="1">Thứ 2</option>
				<option value="2">Thứ 3</option>
				<option value="3">Thứ 4</option>
				<option value="4">Thứ 5</option>
				<option value="5">Thứ 6</option>
				<option value="6">Thứ 7</option>
			</select>
		</td>
		<td>Giờ học:</td>
		<td><input type="time" id="studyTime" name="studyTime" required="true" validatebox="true" /></td>
	</tr>
	</table>
{children all}
</form>