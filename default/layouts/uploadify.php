<img id="{prop id}_image" src="<?php if(@$data->value) { echo createThumb(@$data->value, 80, 80);}?>" height="80px" width="auto"/>
<input id="{prop id}" name="{prop name}" value="{prop value}" type="hidden" />
<input id="{prop id}_uploadify" type="file" />