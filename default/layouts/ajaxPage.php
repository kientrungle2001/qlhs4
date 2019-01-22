<link rel="stylesheet" href="<?php echo BASE_URL?>/public/<?php echo _app()->name . '_' . str_replace('/', '_', pzk_or(@$_REQUEST['page'], 'index')) ?>.css"/>
{ec all}
<script type="text/javascript" src="<?php echo BASE_URL?>/public/<?php echo _app()->name . '_' . str_replace('/', '_',pzk_or(@$_REQUEST['page'], 'index'))  ?>.js"></script>

<script type="text/javascript">
	pzk_init(<?php echo json_encode($data->jsInstances) ?>);
</script>
