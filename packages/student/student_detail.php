<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<?php $student = $data->getDetail();
?>
<div id="student_detail_div">
<!-- Chi tiết học sinh -->
<div class="easyui-tabs" style="width:600px;height:auto;">
<div class="student_detail" title="Chi tiết">
<form>
	<div class="left-column">
		<div class="left-handside">Họ và tên: </div>
		<div class="right-handside">{student[name]}</div>
		<div class="clear"></div>
		<div class="left-handside">Ngày sinh:</div>
		<div class="right-handside">{student[birthDate]}</div>
		<div class="clear"></div>
		<div class="left-handside">Số điện thoại:</div>
		<div class="right-handside">{student[phone]}</div>
		<div class="clear"></div>
	</div>
	<div class="right-column">
		<div class="left-handside">Trường học:</div>
		<div class="right-handside">{student[school]}</div>
		<div class="clear"></div>
		<div class="left-handside">Địa chỉ nhà:</div>
		<div class="right-handside">{student[address]}</div>
		<div class="clear"></div>
		<div class="left-handside">Lớp học:</div>
		<div class="right-handside">{student[classNames]}</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</form>
</div>
<div title="Lịch sử tư vấn">
	<?php
	$rand = rand(0, 1000000);
	$advice = <<<EOD
<dg.dataGrid id="dg_advice_{$rand}" title="Lịch sử tư vấn" nowrap="false" table="advice" width="600px" height="250px" defaultFilters='{"studentId": {$student['id']}}' rowStyler="adviceRowStyler">
	
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="type" width="120" formatter="adviceTypeFormatter">Loại</dg.dataGridItem>
	<dg.dataGridItem field="title" width="120">Tiêu đề</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="120">Môn/Phần mềm</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Khóa học</dg.dataGridItem>
	<dg.dataGridItem field="adviceName" width="120">Người tư vấn</dg.dataGridItem>
	<dg.dataGridItem field="time" width="120">Thời gian</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120" formatter="adviceStatusFormatter">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_advice_{$rand}_toolbar">
		<layout.toolbarItem action="pzk.elements.dg_advice_{$rand}.add(); jQuery('#fm-dg_advice_{$rand} [name=studentId]').val('{$student['id']}');" icon="add" />
		<layout.toolbarItem action="pzk.elements.dg_advice_{$rand}.edit()" icon="edit" />
		<layout.toolbarItem action="pzk.elements.dg_advice_{$rand}.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_advice_{$rand}" width="700px" height="auto" title="Phần mềm">
		<frm.form gridId="dg_advice_{$rand}">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="type" required="false" label="Loại hình">
				<select name="type">
				<option value="5">Hẹn thi đầu vào</option>	
				<option value="0">Cuộc gọi</option>
					<option value="1">Tin nhắn</option>
					<option value="2">Facebook</option>
					<option value="3">Email</option>
					<option value="4">Gặp gỡ</option>
					
				</select>
			</frm.formItem>
			<frm.formItem name="title" required="true" validatebox="true" label="Tiêu đề" />
			<frm.formItem name="content" required="true" validatebox="true" label="Nội dung" />
			<frm.formItem type="hidden" name="studentId" value="{$student['id']}" required="false" label="" />
			<frm.formItem type="datetime-local" name="time" 
					value="{$current_date}" required="false" label="Ngày tư vấn&lt;br /&gt;hẹn thi đầu vào" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
				<form.combobox name="subjectId"
						sql="$subject_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="classId" required="false" label="Khóa học">
				<form.combobox name="classId"
						sql="$class_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="adviceId" required="false" label="Giáo viên">
				<form.combobox name="adviceId"
						sql="$teacher_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
				<select name="status">
					<option value="0">Từ chối</option>
					<option value="1">Đang xem xét</option>
					<option value="2">Đang thử</option>
					<option value="3">Đồng ý</option>
				</select>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
EOD;
	$adviceGrid = pzk_parse($advice);
	$adviceGrid->display();
	?>
</div>
<div title="Lịch hẹn thi đầu vào">
<?php
	$rand = rand(0, 1000000);
	$advice = <<<EOD
<dg.dataGrid id="dg_test_schedule_{$rand}" title="Lịch hẹn thi đầu vào" table="test_schedule" width="600px" height="250px" defaultFilters='{"studentId": {$student['id']}}' nowrap="false">
	
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="testDate" width="120">Ngày test</dg.dataGridItem>
	<dg.dataGridItem field="testTime" width="120">Thời gian</dg.dataGridItem>
	<dg.dataGridItem field="mark" width="120">Điểm số</dg.dataGridItem>
	<dg.dataGridItem field="rating" width="120">Xếp hạng</dg.dataGridItem>
	<dg.dataGridItem field="note" width="120">Ghi chú</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_test_schedule_{$rand}_toolbar">
		<layout.toolbarItem action="pzk.elements.dg_test_schedule_{$rand}.add(); jQuery('#fm-dg_test_schedule_{$rand} [name=studentId]').val('{$student['id']}');" icon="add" />
		<layout.toolbarItem action="pzk.elements.dg_test_schedule_{$rand}.edit()" icon="edit" />
		<layout.toolbarItem action="pzk.elements.dg_test_schedule_{$rand}.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_test_schedule_{$rand}" width="700px" height="auto" title="Phần mềm">
		<frm.form gridId="dg_test_schedule_{$rand}">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="title" required="true" validatebox="true" label="Tiêu đề" />
			<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
			<frm.formItem type="hidden" name="studentId" value="{$student['id']}" required="false" label="" />
			<frm.formItem type="date" name="testDate" 
					value="{$current_date}" required="false" label="Ngày hẹn" />
					<frm.formItem type="time" name="testTime" 
					value="18:00:00" required="false" label="Giờ thi" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
				<form.combobox name="subjectId"
						sql="$subject_center_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="classId" required="false" label="Khóa học">
				<form.combobox name="classId"
						sql="$class_ontest_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="adviceId" required="false" label="Phụ trách">
				<form.combobox name="adviceId"
						sql="$teacher_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
				<select name="status">
					<option value="0">Chưa thi</option>
					<option value="1">Đã thi</option>
					<option value="2">Đã có kết quả</option>
				</select>
			</frm.formItem>
			<frm.formItem name="note" required="false" validatebox="false" label="Điểm số" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
EOD;
	$adviceGrid = pzk_parse($advice);
	$adviceGrid->display();
	?>
</div>
<div title="Bài kiểm tra">
<?php
	$rand = rand(0, 1000000);
	$advice = <<<EOD
<dg.dataGrid id="dg_test_student_mark{$rand}" title="Điểm thi" table="test_student_mark" width="600px" height="250px" defaultFilters='{"studentId": {$student['id']}}' nowrap="false">
	
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="testName" width="120">Bài kiểm tra</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="120">Môn</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Khóa học</dg.dataGridItem>
	<dg.dataGridItem field="mark" width="120">Điểm</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_test_student_mark{$rand}_toolbar">
		<layout.toolbarItem action="pzk.elements.dg_test_student_mark{$rand}.add(); jQuery('#fm-dg_advice_{$rand} [name=studentId]').val('{$student['id']}');" icon="add" />
		<layout.toolbarItem action="pzk.elements.dg_test_student_mark{$rand}.edit()" icon="edit" />
		<layout.toolbarItem action="pzk.elements.dg_test_student_mark{$rand}.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_test_student_mark{$rand}" width="700px" height="auto" title="Bài kiểm tra">
		<frm.form gridId="dg_test_student_mark{$rand}">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="hidden" name="studentId" value="{$student['id']}" required="false" label="" />
			<frm.formItem type="user-defined" name="testId" required="false" label="Bài kiểm tra">
				<form.combobox name="testId"
						sql="$test_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="classId" required="false" label="Khóa học">
				<form.combobox name="classId"
						sql="$class_sql"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="text" name="mark" required="true" label="Điểm" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
EOD;
	$adviceGrid = pzk_parse($advice);
	$adviceGrid->display();
	?>
</div>
<div title="Học phí">
<?php
	$rand = rand(0, 1000000);
	$advice = <<<EOD
<dg.dataGrid id="dg_student_order{$rand}" title="Học phí" table="student_order" width="600px" height="250px" defaultFilters='{"studentId": {$student['id']}}' nowrap="false">
	
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Khóa học</dg.dataGridItem>
	<dg.dataGridItem field="periodName" width="120">Kỳ thanh toán</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="120">Số tiền</dg.dataGridItem>
	<dg.dataGridItem field="created" width="120">Ngày thanh toán</dg.dataGridItem>
</dg.dataGrid>
EOD;
	$adviceGrid = pzk_parse($advice);
	$adviceGrid->display();
	?>
</div>
<div title="Thời khóa biểu">
<?php
	$rand = rand(0, 1000000);
	$advice = <<<EOD
<dg.dataGrid id="dg_schedule{$rand}" title="Thời khóa biểu" table="schedule" width="600px" height="250px" defaultFilters='{"studentId": {$student['id']}}' nowrap="false">
	
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="120">Ngày học</dg.dataGridItem>
	<dg.dataGridItem field="studyTime" width="120">Giờ học</dg.dataGridItem>
</dg.dataGrid>
EOD;
	$adviceGrid = pzk_parse($advice);
	$adviceGrid->display();
	?>
</div>
<div title="Các lớp đã học">
<?php
	$rand = rand(0, 1000000);
	$advice = <<<EOD
<dg.dataGrid id="dg_class_student{$rand}" title="Các lớp đã học" table="class_student" width="600px" height="250px" defaultFilters='{"studentId": {$student['id']}}' nowrap="false">
	
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày học</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày kết thúc</dg.dataGridItem>
</dg.dataGrid>
EOD;
	$adviceGrid = pzk_parse($advice);
	$adviceGrid->display();
	?>
</div>
<!--
<div title="Mượn sách">
Mượn sách
</div>
<div title="Quên đồ">
Quên đồ
</div>
-->
</div>
<!-- Điểm danh - Học phí -->
<div class="easyui-tabs" style="width:600px;height:auto;<?php if($student['online'] == 3):?>display: none; height: 0; visibility: hidden;<?php endif;?>">
<?php 

$classIds = array();
$class_periods = array();
$class_period_mustertotals = array();
$class_period_discounts = array();
$class_period_prices = array();
$classPrices = array();
$class_discount_reasons = array();
foreach ($student['classes'] as $class) { 
	if(strpos($class['name'], 'M') === false) {
		$classIds[] = $class['id'];
		$classPrices[] = $class['amount'];
	}
?>

<div title="Lớp {class[name]} {? echo $class['startClassDate'] == '0000-00-00' ?'': ' - Start: '.date('d/m', strtotime($class['startClassDate'])) ?}{? echo $class['endClassDate'] == '0000-00-00' ?'': ' - End: ' . date('d/m', strtotime($class['endClassDate'])) ?}">
	<?php 
	if(strpos($class['name'], 'M') !== false) { 
		$order = _db()->useCB()->select('orderId')->fromStudent_order()
			->whereStudentId($student['id'])
			->whereClassId($class['id'])
			->wherePayment_periodId('0')
		->whereStatus('');
		$order = $order->result_one();
		
	?>
		<h2>Văn miêu tả</h2>
		<div class="left-handside">
		<?php if ($order) { ?> <a href="<?php echo BASE_URL; ?>/index.php/order/detail?id={order[orderId]}" target="_blank">Xem hóa đơn</a> <?php } else { ?>
		<a href="<?php echo BASE_URL; ?>/index.php/order/create?multiple=1&classIds={class[id]}&studentId={student[id]}&periodId=0&prices={class[amount]}&amounts={class[amount]}&discounts=0&musters=1&discount_reasons=" target="_blank">Tạo hóa đơn</a>
		<?php } ?>
		</div>
		<div class="right-handside"></div><div class="clear"></div>
</div>
<?php
		continue;
	}?>
	<div class="easyui-accordion" style="width:598px;height:auto;">
<?php
	$displayPeriod = true;
	foreach($class['periods'] as $period) { ?>
	<?php if($class['startDate'] !== '0000-00-00' && $class['startDate'] >= $period['endDate']) { $displayPeriod = false; }?>
	<?php if($class['endDate'] !== '0000-00-00' && $class['endDate'] < $period['startDate']) { $displayPeriod = false; }?>
	<?php if($class['startClassDate'] !== '0000-00-00' && $class['startClassDate'] >= $period['endDate']) { $displayPeriod = false; }?>
	<?php if($class['endClassDate'] !== '0000-00-00' && $class['endClassDate'] < $period['startDate']) { $displayPeriod = false; }?>
	<?php $statuses = $data->getStatuses($class['id'], $student['id']);?>
	
	
<?php
		if(!isset($class_periods[$period['id']])){
			$class_periods[$period['id']] = array();
		}
		$class_periods[$period['id']][] = $period['need_amount'];
		
		if(!isset($class_period_mustertotals[$period['id']])){
			$class_period_mustertotals[$period['id']] = array();
		}
		$class_period_mustertotals[$period['id']][] = isset($period['total'])?$period['total']: '0';
		
		if(!isset($class_period_discounts[$period['id']])){
			$class_period_discounts[$period['id']] = array();
		}
		$class_period_discounts[$period['id']][] = $period['discount_amount'];
	?>
	<?php if(!$displayPeriod) { 
		echo '<!--';
	} ?>
		<?php $att_dates = 0;?>
		<?php $dates = $data->getStudyDates($class['id']); ?>
		{each $dates as $date}
			<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
			<?php if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $date['studyDate']) { ?>
			<?php if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $date['studyDate']) { ?>
			<?php if ($class['startClassDate'] == '0000-00-00' || $class['startClassDate'] <= $date['studyDate']) { ?>
			<?php if ($class['endClassDate'] == '0000-00-00' || $class['endClassDate'] > $date['studyDate']) { ?>
			<?php $att_dates++;?>
			<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php } ?>
		{/each}
		<?php if($att_dates !== 0): ?>
		<div title="{period[name]}">
			
			<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
			<tr>
				{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<?php if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $date['studyDate']) { ?>
					<?php if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $date['studyDate']) { ?>
					<?php if ($class['startClassDate'] == '0000-00-00' || $class['startClassDate'] <= $date['studyDate']) { ?>
					<?php if ($class['endClassDate'] == '0000-00-00' || $class['endClassDate'] > $date['studyDate']) { ?>
					<th>{? echo date('d/m', strtotime($date['studyDate']))?}</th>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
				{/each}
			</tr>
			<tr>
				{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<?php if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $date['studyDate']) { ?>
					<?php if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $date['studyDate']) { ?>
					<?php if ($class['startClassDate'] == '0000-00-00' || $class['startClassDate'] <= $date['studyDate']) { ?>
					<?php if ($class['endClassDate'] == '0000-00-00' || $class['endClassDate'] > $date['studyDate']) { ?>
					<td><select class="muster_{class[id]}_{date[studyDate]}" id="muster_{class[id]}_{student[id]}_{date[studyDate]}" name="muster[{class[id]}][{student[id]}][{date[studyDate]}]"
							onchange="submitMuster('{class[id]}', '{student[id]}', '{date[studyDate]}', this.value)">
						<option value="0">N/A</option>
						<option value="1">CM</option>
						<option value="2">NTT</option>
						<option value="3">NKT</option>
						<option value="4">KTT</option>
						<option value="5">DH</option>
					</select>
					</td>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					{/each}
			</tr>
			</table>
			<div class="left-column">
				<div class="left-handside">Điểm danh: </div><div class="right-handside">{period[total]}</div><div class="clear"></div>
				<div class="left-handside">Số buổi học:</div><div class="right-handside">{period[1]}</div><div class="clear"></div>
				<div class="left-handside">Nghỉ trừ tiền:</div><div class="right-handside">{period[2]}</div><div class="clear"></div>
				<div class="left-handside">Nghỉ K.trừ tiền:</div><div class="right-handside">{period[3]}</div><div class="clear"></div>
				<div class="left-handside">Lý do:</div><div class="right-handside">
				
				<?php if(isset($period['last_period'])) { 
					$last_period = $period['last_period'];
					$period['reason'] = @$period['reason'] ." ". @$last_period['later_reason'];
				} ?>
				{period[reason]}
				<?php 
				if(!isset($class_discount_reasons[$period['id']])){
					$class_discount_reasons[$period['id']] = array();
				}
				$class_discount_reasons[$period['id']][] = @$period['reason'];
				?>
				</div><div class="clear"></div>
			</div>
			<div class="right-column">
				<div class="left-handside">Học phí:</div><div class="right-handside">{? echo product_price($period['amount']) ?}</div><div class="clear"></div>
				<div class="left-handside">Trừ sang tháng sau:</div><div class="right-handside">{? echo product_price($period['next_discount_amount']) ?}</div><div class="clear"></div>
				<div class="left-handside">Lý do:</div><div class="right-handside">{period[later_reason]}</div><div class="clear"></div>
				<div class="left-handside">Trừ từ tháng trước:</div><div class="right-handside">{? echo product_price($period['discount_amount']) ?}</div><div class="clear"></div>
				<div class="left-handside">Phải đóng:</div><div class="right-handside">{? echo product_price($period['need_amount']) ?}</div><div class="clear"></div>
				<?php 
				// var_dump($period['orderId']);
				if(isset($period['orderId'])) { 
				$order = _db()->select('orderId')->from('student_order')->where('id=' . $period['orderId'])->result_one();
				?>
				<div class="left-handside"><a href="<?php echo BASE_URL; ?>/index.php/order/detail?id={order[orderId]}" target="_blank">Xem hóa đơn</a></div><div class="right-handside"></div><div class="clear"></div>
				<?php } else { ?>
				<div class="left-handside"><a href="<?php echo BASE_URL; ?>/index.php/order/create?multiple=1&classIds={class[id]}&studentId={student[id]}&periodId={period[id]}&amounts={period[need_amount]}&discounts={period[discount_amount]}&musters={period[total]}&discount_reasons={period[reason]}&prices={class[amount]}" target="_blank">Tạo hóa đơn</a></div><div class="right-handside"></div><div class="clear"></div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php endif;?>
	<?php if(!$displayPeriod) { 
		echo '-->';
	} ?>
	<?php } ?>

		<script type="text/javascript">
var statuses = <?php echo json_encode($statuses)?>;
$(document).ready(function(e) {
	for(var i=0; i < statuses.length; i++) {
		var classId = statuses[i]['classId'];
		var studentId = statuses[i]['studentId'];
		var studyDate = statuses[i]['studyDate'];
		var status = statuses[i]['status'];
		$('#muster_' + classId + '_' + studentId + '_' + studyDate).val(status);
	}
});
</script>
	</div>
	
</div>
<?php } ?>
<div title="Hóa đơn tổng">
	<h2>Hóa đơn tổng</h2>
	<div style="width:578px;height:auto;">
	<?php 
	if(isset($class) && $class)
	foreach($class['periods'] as $period) { ?>
	<?php $displayPeriod = true; ?>
	<?php if($class['startDate'] !== '0000-00-00' && $class['startDate'] >= $period['endDate']) { $displayPeriod = false; }?>
	<?php if($class['endDate'] !== '0000-00-00' && $class['endDate'] < $period['startDate']) { $displayPeriod = false; }?>
	<?php if($class['startClassDate'] !== '0000-00-00' && $class['startClassDate'] >= $period['endDate']) { $displayPeriod = false; }?>
	<?php if($class['endClassDate'] !== '0000-00-00' && $class['endClassDate'] < $period['startDate']) { $displayPeriod = false; }?>

		<div title="{period[name]}" style="display: <?php echo ($displayPeriod? 'block': 'none')?>">
			<h3>{period[name]}</h3>
			<div class="left-handside">
			<?php $all_amounts = @$class_periods[$period['id']];
			$total_amounts = 0;
			if(!$all_amounts) $all_amounts = array();
			foreach($all_amounts as $each_amount) {
				$total_amounts += $each_amount;
			}
			
			?>
			Tổng cộng: <?php echo product_price($total_amounts);?> &nbsp;
<a href="<?php echo BASE_URL; ?>/index.php/order/create?multiple=1&prices={? echo @implode(',', @$classPrices) ?}&classIds={? echo @implode(',', @$classIds) ?}&studentId={student[id]}&periodId={period[id]}&discounts={? echo @implode(',', @$class_period_discounts[$period['id']]) ?}&musters={? echo @implode(',', @$class_period_mustertotals[$period['id']]) ?}&amounts={? echo @implode(',', @$class_periods[$period['id']]) ?}&discount_reasons={? echo @implode(',', @$class_discount_reasons[$period['id']]) ?}" target="_blank">Tạo hóa đơn</a></div><div class="right-handside"></div><div class="clear"></div>
		</div>
	<?php } ?>
	</div>
</div>
</div>
</div>
<style type="text/css">
	.left-column, .right-column {
		float: left;
		width: 49%;
	}
	.left-column {
		border-right: 1px solid black;
	}
	.right-column {
		margin-left:5px;
	}
	.left-handside, .right-handside{
		float: left;
	}
	.left-handside {
		width: 100px;
		float: left;
	}
	.right-handside {
		width: 190px;
	}
</style>
<script type="text/javascript">
	$('#student_detail_div .easyui-datagrid').datagrid();
	$('#student_detail_div .easyui-panel').panel();
	$('#student_detail_div .easyui-tabs').tabs();
	$('#student_detail_div .easyui-accordion').accordion();
	$('#student_detail_div .easyui-linkbutton').linkbutton();
	$('#student_detail_div .easyui-dialog').dialog();
	$('#student_detail_div .easyui-validatebox').validatebox();
	function submitMuster(classId, studentId, studyDate, status) {
		$.ajax({
			type: 'post',
			method: 'post',
			url: BASE_URL + '/index.php/Dtable/replace?table=student_schedule',
			data: {classId: classId, studentId: studentId, studyDate: studyDate, status: status},
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
	function adviceStatusFormatter(value,row,index) {
		switch(value) {
			case '0': return 'Từ chối';
			case '1': return 'Đang xem xét';
			case '2': return 'Đang thử';
			case '3': return 'Đồng ý';
		}
	}
	function adviceTypeFormatter(value,row,index) {
		switch(value) {
			case '0': return 'Cuộc gọi';
			case '1': return 'Tin nhắn';
			case '2': return 'Facebook';
			case '3': return 'Email';
			case '4': return 'Gặp gỡ';
		}
	}
	function adviceRowStyler(index, row) {
		if(row.status == '0') {
			return 'color: red; font-weight: bold;';
		}
		if(row.status == '1') {
			return 'color: orange; font-weight: bold;';
		}
		if(row.status == '2') {
			return 'color: blue; font-weight: bold;';
		}
		if(row.status == '3') {
			return 'color: green; font-weight: bold;';
		}
		return '';
	}
</script>
