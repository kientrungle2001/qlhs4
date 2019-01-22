<div>
	<?php
		$classes = $data->getClasses();
		$payment_periods = $data->getPaymentPeriods();
	?>
	{each $classes as $class}
		{class[name]}
		{each $payment_periods as $period}
			<input type="checkbox" name="class_payment_period[{class[id]}][{period[id]}]" value="1" />
			 {period[name]}
		{/each}
		<br />
	{/each}
</div>