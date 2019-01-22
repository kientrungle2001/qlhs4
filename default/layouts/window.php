<div class="pzk_window {e class}" 
	name="{e name}" 
	style="width: {e width};height: {e height}; {e style}"
	onmouseover="$(this).addClass('pzk_window_highlighted')"; onmouseout="$(this).removeClass('pzk_window_highlighted')">
	<div class="pzk_window_title_bar">
		<div class="pzk_window_title">{e title}</div>
		<?php if ($data->closable == 'closable') { ?>
		<div class="pzk_window_close_button">X</div>
		<?php }?>
		<div class="clear"></div>
	</div>
	<div class="pzk_window_content">
		{e text}
		{ec all}
	</div>
	<div class="pzk_window_status">{e status}</div>
</div>