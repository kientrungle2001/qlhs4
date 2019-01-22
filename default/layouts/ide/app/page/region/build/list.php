<?php
$build = pzk_element('build');
$item = $build->getItem();
?>
List Name: <input type="text" name="name" /><br />
Layout: <br />
<textarea type="hidden" name="layout" id="region-layout" >{item[layout]}</textarea>
<br />