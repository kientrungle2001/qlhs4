<page id="page" title="Quản trị">
	<html.head id="head">
		<script>
			BASE_URL = '<?php echo BASE_URL?>';
			BASE_REQUEST = '<?php echo BASE_REQUEST?>';
		</script>
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery/jquery-3.3.1.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/bootstrap-4.2.1-dist/js/bootstrap.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery-ui-1.12.1.custom/jquery-ui.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery-ui-1.12.1.custom/datepicker-vi.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/js/components.js"></html.js>
		<!--
		<html.js src="<?php echo BASE_URL?>/3rdparty/easyui/jquery.easyui.min.js" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/easyui/themes/default/easyui.css" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/easyui/themes/icon.css" />
		<html.js src="<?php echo BASE_URL?>/js/qlhs.js" />
		-->
		<html.js src="<?php echo BASE_URL?>/3rdparty/angularjs/1.7.6/angular.min.js" />
		<html.js src="<?php echo BASE_URL?>/3rdparty/angularjs/1.7.6/angular-sanitize.min.js" />
		<html.js src="<?php echo BASE_URL?>/js/erp.js?t=<?php echo date('YmdH')?>" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/bootstrap-4.2.1-dist/css/bootstrap.min.css"></html.css>
		<html.css src="<?php echo BASE_URL?>/3rdparty/font-awesome-4.7.0/css/font-awesome.min.css"></html.css>
		<html.css src="<?php echo BASE_URL?>/3rdparty/jquery-ui-1.12.1.custom/jquery-ui.min.css"></html.css>
		<html.js src="<?php echo BASE_URL?>/xcss" />
		<html.css src="<?php echo BASE_URL?>/xcss/output/erp.css" />
		<!--
		<html.css src="<?php echo BASE_URL?>/xcss/output/test.css" />
		-->
	</html.head>
	<html.body>
		<div layout="dropdown-menu" />
		<block id="wrapper">			
			<block id="content">
				<block id="left" class="container-fluid" />
			</block>
		</block>
	</html.body>	
</page>