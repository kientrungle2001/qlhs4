<page id="page" title="Quản trị">
	<html.head id="head">
	<script>
			BASE_URL = '<?php echo BASE_URL?>';
			BASE_REQUEST = '<?php echo BASE_REQUEST?>';
		</script>
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery/jquery-3.3.1.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/bootstrap-4.2.1-dist/js/bootstrap.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/js/components.js"></html.js>
		<html.css src="<?php echo BASE_URL?>/3rdparty/bootstrap-4.2.1-dist/css/bootstrap.min.css"></html.css>
		<html.css src="<?php echo BASE_URL?>/3rdparty/font-awesome-4.7.0/css/font-awesome.min.css"></html.css>
		
	</html.head>
	<html.body>
		<block id="wrapper">			
			<block id="content">
				<block id="left">
					<div layout="login" />
				</block>
			</block>
		</block>
	</html.body>	
</page>