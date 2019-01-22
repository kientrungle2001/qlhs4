<page id="page" title="Quản trị">
	<html.head id="head">
		<script>
			BASE_URL = '<?php echo BASE_URL?>';
			BASE_REQUEST = '<?php echo BASE_REQUEST?>';
		</script>
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery/jquery-1.7.1.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/js/components.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/easyui/jquery.easyui.min.js" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/easyui/themes/default/easyui.css" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/easyui/themes/icon.css" />
		<html.js src="<?php echo BASE_URL?>/js/qlhs.js" />
	<!--
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery-easyui-1.6.8/jquery.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/js/components.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery-easyui-1.6.8/jquery.easyui.min.js" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/jquery-easyui-1.6.8/themes/bootstrap/easyui.css" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/jquery-easyui-1.6.8/themes/icon.css" />
	-->
		<html.js src="<?php echo BASE_URL?>/xcss" />
		<html.css src="<?php echo BASE_URL?>/xcss/output/test.css" />
	</html.head>
	<html.body>
		<div layout="dropdown-menu" />
		<block id="wrapper">			
			<block id="content">
				<block id="left" width="1321px" />
			</block>
		</block>
	</html.body>	
</page>