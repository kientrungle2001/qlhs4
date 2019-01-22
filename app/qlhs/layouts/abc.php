<html>
<head>
{children [id=head]}
</head>
<body>
{children [id=body]}	
<?php if (count($data->jsInstances)) { ?>
<script type="text/javascript">
	pzk_init(<?php echo json_encode($data->jsInstances) ?>);
</script>
<?php } ?>
</body>
</html>