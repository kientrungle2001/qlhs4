<table>
<?php
	$students = $data->getStudents();
	foreach($students as $student) {?>
	<tr>
		<td>{student[name]}</td>
		<td>
		<select name="status[{student[id]}]" onchange="musterChangeStudentStatus(this, {student[id]})">
			<option value="1">Có mặt</option>
			<option value="-1">Vắng mặt</option>
			<option value="-2">Vắng mặt có phép</option>
		</select>
		</td>
		<td>
		<span id="reason_{student[id]}" style="display: none;">
			Lý do: <input id="input_{student[id]}" name="note[{student[id]}]" />
		</span>
		</td>
	</tr>
<?php	
	}
?>
</table>