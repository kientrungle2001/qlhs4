<?php
$orders = $data->getOrders();
$total = 0;
?>
<table class="order-table" border="1" style="border-collapse: collapse;">
	<tr>
		<th>Order ID</th>
		<th>Người nộp</th>
		<th>Số điện thoại</th>
		<th>Lý do</th>
		<th>Số tiền</th>
		<th>Ngày tạo</th>
		<th>Quyển</th>
		<th>Số</th>
	</tr>
<?php $totalByDate = 0; $totalToDate = 0; $orderdate = false; ?>
{each $orders as $order}
<?php 
	if($orderdate != $order['created']) { ?>
	<?php if($orderdate != false) { ?>
		<tr style="background: white;">
			<td colspan="4">Cộng dồn ngày hôm trước {? echo date('d/m/Y', strtotime($orderdate)); ?}</td>
			<td colspan="1">{? echo product_price($totalToDate); ?}</td>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr style="background: white;">
			<td colspan="4">Ngày {? echo date('d/m/Y', strtotime($orderdate)); ?}</td>
			<td colspan="1">{? echo product_price($totalByDate); ?}</td>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr style="background: white;">
			<td colspan="4">Tổng đến ngày {? echo date('d/m/Y', strtotime($orderdate)); ?}</td>
			<td colspan="1">{? echo product_price($totalByDate + $totalToDate); ?}</td>
			<td colspan="3">&nbsp;</td>
		</tr>
	<?php } ?>
	
	<?php
		$orderdate = $order['created'];
		$totalToDate += $totalByDate;
		$totalByDate = 0;
	}
	$totalByDate += $order['amount'];
?>
	<tr>
	<td>#{order[id]}</td>
	<td>{order[name]}</td>
	<td>{order[phone]}</td>
	<td>{order[reason]}</td>
	<td>{? echo product_price($order['amount']); $total += $order['amount']; ?}</td>
	<td>{? echo date('d/m/Y', strtotime($order['created'])); ?}</td>
	<td>{order[bookNum]}</td>
	<td>{order[noNum]}</td>
	</tr>
{/each}
	<tr style="background: white;">
		<td colspan="4">Cộng dồn ngày hôm trước {? echo date('d/m/Y', strtotime($orderdate)); ?}</td>
		<td colspan="1">{? echo product_price($totalToDate); ?}</td>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr style="background: white;">
		<td colspan="4">Ngày {? echo date('d/m/Y', strtotime($orderdate)); ?}</td>
		<td colspan="1">{? echo product_price($totalByDate); ?}</td>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr style="background: white;">
		<td colspan="4">Tổng đến ngày {? echo date('d/m/Y', strtotime($orderdate)); ?}</td>
		<td colspan="1">{? echo product_price($totalByDate + $totalToDate); ?}</td>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th style="text-align: right;">Tổng: </th>
		<th>{? echo product_price($total) ?}</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
</table>
<style type="text/css">
	.order-table td {
		padding: 5px;
	}
</style>