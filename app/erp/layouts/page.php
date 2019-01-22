<!DOCTYPE html><html>
<head>
	<title>{prop title}</title>
	<meta name="google-site-verification" content="<?php echo pzk_app()->gsv?>" />
	<meta content="width=device-width, height=device-height initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"  name="viewport"  />
	<meta name="keywords" content="{prop keywords}" />
	<meta name="description" content="{prop description}" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="canonical" href="http://phattrienngonngu.com/" />
	<script type="text/javascript">
		BASE_URL = '<?php echo BASE_URL?>';
	</script>
	
</head>
<body>
{children [tagName=html.body]}
{children [tagName=html.head]}
<script type="text/javascript" src="<?php echo BASE_URL ?>/public/<?php echo pzk_app()->name . '_' . pzk_or(@$_REQUEST['page'], 'index') ?>.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/public/<?php echo pzk_app()->name . '_' . pzk_or(@$_REQUEST['page'], 'index') ?>.css"/>
<?php if (count($data->jsInstances)) { ?>
		<script type="text/javascript">
			pzk_init(<?php echo json_encode($data->jsInstances) ?>);
		</script>
		<?php } ?>
<!--
<script type="text/javascript">
	setInterval(function() {
		$.ajax({
			url: '/test/clientsync.php',
			async: false
		});
	}, 5000);
</script>
-->
</body>
</html>