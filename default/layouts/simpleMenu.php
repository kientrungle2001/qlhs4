<ul {ea id}>
<?php
foreach($data->items as $topMenu) {?>
	<li onmouseover="$('#subMenu-<?php echo $topMenu['id'] ?>').show();" 
		onmouseout="$('#subMenu-<?php echo $topMenu['id'] ?>').hide();">
		<a href="/index.php/<?php echo $topMenu['link'] ?>">
			<?php echo $topMenu['label'] ?></a>
		<ul id="subMenu-<?php echo $topMenu['id'] ?>">
		<?php
		if (@$topMenu['items']) foreach($topMenu['items'] as $subMenu) {?>
			<li><a href="/index.php/<?php echo $subMenu['link'] ?>">
				<?php echo $subMenu['label'] ?></a></li>
		<?php
		}?>
		</ul>
	</li>
<?php
}
?>
</ul>