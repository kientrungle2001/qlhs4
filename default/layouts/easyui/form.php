<form id="<?php if(@$data->gridId) { ?>fm-{prop gridId}<?php } else { ?>{prop id}<?php } ?>" method="post" {attrs onSubmit, onsubmit, action}>
	<table>{children [className=PzkEasyuiFormFormItem]}</table>
</form>