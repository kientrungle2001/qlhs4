<?php
$periods = _db()->select('*')->from('payment_period')->result();
?>
Kỳ thanh toán: 
<select id="periods" name="payment_period" onchange="pzk_student.periodselect(this.value);">
	<option value="">&nbsp;</option>
	<?php foreach($periods as $period) { ?>
		<option value="{period[id]}">{period[name]}</option>
	<?php } ?>
</select>
<input name="payment" type="checkbox" value="0" checked="checked" onchange="pzk_student.paymentstate(this.value, this.checked)" />Chưa thanh toán | 
<input name="payment" type="checkbox" value="1" checked="checked" onchange="pzk_student.paymentstate(this.value, this.checked)"/> Đã thanh toán