<div class="easyui-accordion" style="width:1100px;height:auto;padding: 5px;">
<?php
	$class = $data->getClass();
	$students = $data->getStudents();
	$teachers = $data->getTeachers(@$class['teacherId'], @$class['teacher2Id']);
	$teacher = false; $teacher2 = false;
	if ($class['teacherId']) {
		$teacher = $teachers[$class['teacherId']];
	}
	if ($class['teacher2Id']) {
		$teacher2 = $teachers[$class['teacher2Id']];
	}
	$orders = $data->getStructureOrders();
	$periods = $data->getPaymentPeriods(0);
	$schedules = $data->getStructureScheduleSummary();
	$summary = $data->getTotalScheduleSummary();
	$teacherSummary = $data->getTotalTeacherScheduleSummary(@$class['teacherId'], @$class['teacher2Id']);
	?>
	<?php if(strpos($class['name'], 'M') !== false) { ?>
		<a href="{url /demo/paymentstatPrint}?classId={class[id]}&periodId=0" target="_blank">Xem bản in</a>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="9">{class[name]}</th>
		</tr>
		<tr>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>CM</th>
			<th>NKT</th>
			<th>NTT</th>
			<th>KTT</th>
			<th>DH</th>
			<th>Học phí</th>
			<th>Trạng thái</th>
			
		</tr>
		<?php $studentAmounts = array();
		$index = 0;
		?>
		{each $students as $student}	
		{? $index++; ?}
		<tr>
			<td>{index}. {student[name]}</td>
			<td>{student[phone]}</td>
			<?php $lastDiscount = 0; $currentDiscount = 0; $totalAmount = 0;?>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][0]['status']['1']?>&nbsp;</td>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][0]['status']['3']?>&nbsp;</td>
			<td style="text-align: right;"><?php echo ($currentDiscount = @$schedules[$class['id']][$student['id']][0]['status']['2'])?>&nbsp;</td>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][0]['status']['4']?>&nbsp;</td>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][0]['status']['5']?>&nbsp;</td>
			<?php 
				if(isset($orders[$class['id']][$student['id']][0])) {
					foreach($orders[$class['id']][$student['id']][0] as $order) { 
					$totalAmount += $order['amount'];
					$studentAmounts[0] = @$studentAmounts[0] + $order['amount'];
					?>
						<td style="text-align: right;">
							<?php echo product_price($order['amount'])?>
						</td>
						<td style="text-align: right;">
						<span title="{order[amount]}đ">Đã thanh toán</span>
						</td>
				<?php 
					}
				} else { if(0) { ?>
					<a href="javascript:void(0)" onclick="makeOrder('{class[id]}', '{student[id]}', '0', '<?php echo ((@$summary[$class['id']][0] - $lastDiscount) * $class['amount']); ?>')"> Đóng tiền</a>
				<?php } ?>
				<?php $hocphi = ((@$summary[$class['id']][0] - $lastDiscount) * $class['amount']); ?>
					<td style="text-align: right;">
						<?php echo product_price($hocphi);?>
					</td>
					<td style="text-align: right;">
					Chưa thanh toán
					</td>
				<?php
				} ?>
            
			<?php $lastDiscount = $currentDiscount;?>
		</tr>
		{/each}
		
		<tr>
			<td colspan="4" align="right">Tổng cộng</td>
			<td colspan="4" align="right"><?php echo product_price(@$studentAmounts[0])?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="right">Tổng kết</td>
			<td colspan="5">
			
		<?php 
			$teacherTotal = 0;
		if ($teacher) { 
			$teacherTotal = @$teacherSummary[$class['id']][0][$teacher['id']];?>
			GV <strong>{teacher[name]}</strong> dạy: <?php echo pzk_or($teacherTotal, '0 ') ?> buổi<br />
		<?php } ?>
		
		<?php 
			$teacher2Total = 0;
		if ($teacher2) { 
			$teacher2Total = @$teacherSummary[$class['id']][0][$teacher2['id']];?>
			GV <strong>{teacher2[name]}</strong> dạy: <?php echo pzk_or($teacher2Total, '0 ') ?> buổi<br />
		<?php } ?>
		<?php
			$total = $teacherTotal + $teacher2Total;
			$teacherAmount = 0;
			$teacher2Amount = 0;
			if($total) {
				if ($teacher) {
					$teacherAmount = @$studentAmounts[0] * ($teacherTotal / $total) * ($teacher['salary'] / 100);
				}
				if ($teacher2) {
					$teacher2Amount = @$studentAmounts[0] * ($teacher2Total / $total) * ($teacher2['salary'] / 100);
				}
			}
		?>
		<?php if ($teacher && $teacherAmount) { ?>
			Lương GV <strong>{teacher[name]}</strong>: <?php echo product_price(pzk_or($teacherAmount, '0')) ?> ({teacher[salary]}%)<br />
		<?php } ?>
		<?php if ($teacher2 && $teacher2Amount) { ?>
			Lương GV <strong>{teacher2[name]}</strong>: <?php echo product_price(pzk_or($teacher2Amount, '0')) ?> ({teacher2[salary]}%)<br />
		<?php } ?>
		Doanh thu trung tâm: <?php echo product_price(@$studentAmounts[0] - ($teacherAmount + $teacher2Amount)); ?>
			</td>
		</tr>
	</table>
	<?php 
	} else { ?>
	{each $periods as $period}
		<?php if($class['startDate'] !== '0000-00-00' && $class['startDate'] >= $period['endDate']) { continue; }?>
		<?php if($class['endDate'] !== '0000-00-00' && $class['endDate'] < $period['startDate']) { continue; }?>
	<div title="{period[name]}">
	<a href="{url /demo/paymentstatPrint}?classId={class[id]}&periodId={period[id]}" target="_blank">Xem bản in</a>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="9">{period[name]} (<?php echo pzk_or(@$summary[$class['id']][$period['id']], '<span>0</span>'); ?> buổi)</th>
		</tr>
		<?php ($total = @$summary[$class['id']][$period['id']] * $class['amount']); ?>
		<tr>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>CM</th>
			<th>NKT</th>
			<th>NTT</th>
			<th>KTT</th>
			<th>DH</th>
			<th>Học phí</th>
			<th>Trạng thái</th>
			
		</tr>
		<?php $studentAmounts = array();
		$index = 0;
		$paid = 0;
		$nonpaid = 0;
		?>
		{each $students as $student}
		<?php if ($student['endStudyDate'] !== '0000-00-00' && $student['endStudyDate'] < $period['startDate']) { continue; } ?>
				<?php if ($student['startStudyDate'] !== '0000-00-00' && $student['startStudyDate'] > $period['endDate']) { continue; } ?>
				<?php if ($student['endClassDate'] !== '0000-00-00' && $student['endClassDate'] < $period['startDate']) { continue; } ?>
				<?php if ($student['startClassDate'] !== '0000-00-00' && $student['startClassDate'] > $period['endDate']) { continue; } ?>
		{? $index++; ?}
		<tr>
			<td>{index}. {student[name]}</td>
			<td>{student[phone]}</td>
			<?php $lastDiscount = 0; $currentDiscount = 0; $totalAmount = 0;?>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][$period['id']]['status']['1']?>&nbsp;</td>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][$period['id']]['status']['3']?>&nbsp;</td>
			<td style="text-align: right;"><?php echo ($currentDiscount = @$schedules[$class['id']][$student['id']][$period['id']]['status']['2']); ?>&nbsp;</td>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][$period['id']]['status']['4']?>&nbsp;</td>
			<td style="text-align: right;"><?php echo @$schedules[$class['id']][$student['id']][$period['id']]['status']['5']?>&nbsp;</td>
			
				<?php 
				if(isset($orders[$class['id']][$student['id']][$period['id']])) {
					foreach($orders[$class['id']][$student['id']][$period['id']] as $order) { 
					$totalAmount += $order['amount'];
					$studentAmounts[$period['id']] = @$studentAmounts[$period['id']] + $order['amount'];
					$paid++;
					?>
						<td style="text-align: right;">
							<?php echo product_price($order['amount'])?>
						</td>
						<td style="text-align: right;">
						<span title="{order[amount]}đ">Đã thanh toán</span>
						</td>
				<?php 
					}
				} else { if(0) { ?>
					<a href="javascript:void(0)" onclick="makeOrder('{class[id]}', '{student[id]}', '{period[id]}', '<?php echo ((@$summary[$class['id']][$period['id']] - $lastDiscount) * $class['amount']); ?>')"> Đóng tiền</a>
				<?php } ?>
				<?php $hocphi = ((@$summary[$class['id']][$period['id']] - $lastDiscount) * $class['amount']); ?>
					<td style="text-align: right;">
						<?php echo product_price($hocphi);?>
					</td>
					<td style="text-align: right;">
					Chưa thanh toán<?php $nonpaid++; ?>
					</td>
				<?php
				} ?>
            
			<?php $lastDiscount = $currentDiscount;?>
		</tr>
		{/each}
		
		<tr>
			<td colspan="4" align="right">Đã thanh toán</td>
			<td colspan="4" align="right"><?php echo $paid; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="right">Chưa thanh toán</td>
			<td colspan="4" align="right"><?php echo $nonpaid; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="right">Tổng cộng</td>
			<td colspan="4" align="right"><?php echo product_price(@$studentAmounts[$period['id']])?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="right">Tổng kết</td>
			<td colspan="5">
			
		<?php 
			$teacherTotal = 0;
		if ($teacher) { 
			$teacherTotal = @$teacherSummary[$class['id']][$period['id']][$teacher['id']];?>
			GV <strong>{teacher[name]}</strong> dạy: <?php echo pzk_or($teacherTotal, '0 ') ?> buổi<br />
		<?php } ?>
		
		<?php 
			$teacher2Total = 0;
		if ($teacher2) { 
			$teacher2Total = @$teacherSummary[$class['id']][$period['id']][$teacher2['id']];?>
			GV <strong>{teacher2[name]}</strong> dạy: <?php echo pzk_or($teacher2Total, '0 ') ?> buổi<br />
		<?php } ?>
		<?php
			$total = $teacherTotal + $teacher2Total;
			$teacherAmount = 0;
			$teacher2Amount = 0;
			if($total) {
				if ($teacher) {
					$teacherAmount = @$studentAmounts[$period['id']] * ($teacherTotal / $total) * ($teacher['salary'] / 100);
				}
				if ($teacher2) {
					$teacher2Amount = @$studentAmounts[$period['id']] * ($teacher2Total / $total) * ($teacher2['salary'] / 100);
				}
			}
		?>
		<?php if ($teacher && $teacherAmount) { ?>
			Lương GV <strong>{teacher[name]}</strong>: <?php echo product_price(pzk_or($teacherAmount, '0')) ?> ({teacher[salary]}%)<br />
		<?php } ?>
		<?php if ($teacher2 && $teacher2Amount) { ?>
			Lương GV <strong>{teacher2[name]}</strong>: <?php echo product_price(pzk_or($teacher2Amount, '0')) ?> ({teacher2[salary]}%)<br />
		<?php } ?>
		Doanh thu trung tâm: <?php echo product_price(@$studentAmounts[$period['id']] - ($teacherAmount + $teacher2Amount)); ?>
			</td>
		</tr>
	</table>
	</div>
	{/each}
<?php } ?>
</div>