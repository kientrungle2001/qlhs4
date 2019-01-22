<ul class="pzk_tab_header">

<?php 
	$tabIndex = 1;
	foreach($data->children as $tab) {?>
		<li><a id="{e id}_header_{e tabIndex}" href="#{e id}_content_{e tabIndex}"><?php echo $tab->label?></a></li>
<?php 
		$tabIndex ++;
	}?>
</ul>
<?php 
	$tabIndex = 1;
	foreach($data->children as $tab) {?>
		<div class="pzk_tab_content" id="{e id}_content_{e tabIndex}">
			<?php $tab->display()?>
		</div>
<?php 
		$tabIndex++;
	}?>