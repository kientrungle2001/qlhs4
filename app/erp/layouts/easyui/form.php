<form id="<?php if(@$data->gridId) { ?>fm-{prop gridId}<?php } else { ?>{prop id}<?php } ?>" method="post" {attrs onSubmit, onsubmit, action}>
	<div class="clearfix form-elements">{children [className=PzkEasyuiFormFormItem]}</div>
</form>