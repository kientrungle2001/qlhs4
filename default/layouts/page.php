<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{prop title}</title>
		<script type="text/javascript">
			BASE_URL = '<?php echo BASE_URL ?>';
		</script>
		<meta name="keywords" content="{prop keywords}" />
		<meta name="description" content="{prop description}" />
		<script type="text/javascript" src="<?php echo BASE_URL ?>/public/<?php echo pzk_app()->name . '_' . pzk_or(@$_REQUEST['page'], 'index') ?>.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL ?>/public/<?php echo pzk_app()->name . '_' . pzk_or(@$_REQUEST['page'], 'index') ?>.css"/>
	</head>
	<body>
		{children all}
		<?php if (count($data->jsInstances)) { ?>
		<script type="text/javascript">
			pzk_init(<?php echo json_encode($data->jsInstances) ?>);
		</script>
		<?php } ?>
	</body>
</html>