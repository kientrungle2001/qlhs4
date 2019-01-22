<?php
$elementCode = $data->item['code'];
$elementStyle = @$data->item['style'];
eval('?>' .PzkParser::parseTemplate($elementCode, array()) . '<?php ');
if(trim($elementStyle)) {
	echo '<style type="text/css">'; 
	eval('?>' .PzkParser::parseTemplate($elementStyle, array()) . '<?php ');
	echo '</style>';
}