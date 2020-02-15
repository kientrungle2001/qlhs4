<h3>Thống kê</h3>
<?php $stats = $data->getStats();?>
<table class="datagrid-btable datagrid-htable" style="width: 100%;">
	<tbody class="datagrid-body">
		<tr class="datagrid-header-row">
			<td>Giáo viên</td>
			<td>Lớp</td>
			<td>Điểm danh</td>
		</tr>
{each $stats as $stat}
<tr class="datagrid-row">
	<td>{stat[teacherName]}</td>
	<td>{stat[className]}</td>
	<td>{stat[muster]} buổi</td>
</tr>
{/each}
	</tbody>
</table>