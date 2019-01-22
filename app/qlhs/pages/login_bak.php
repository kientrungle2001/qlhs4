<page id="page" title="Quản trị">
	<html.head id="head">
		<html.js src="<?php echo BASE_URL?>/3rdparty/jquery/jquery-1.7.1.min.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/js/components.js"></html.js>
		<html.js src="<?php echo BASE_URL?>/3rdparty/easyui/jquery.easyui.min.js" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/easyui/themes/default/easyui.css" />
		<html.css src="<?php echo BASE_URL?>/3rdparty/easyui/themes/icon.css" />
		<html.js src="<?php echo BASE_URL?>/xcss" />
		<html.css src="<?php echo BASE_URL?>/xcss/output/test.css" />
	</html.head>
	<html.body>
		<block id="wrapper">			
			<block id="content">
				<block id="left" width="1000px">
					<frm.form id="loginForm" title="Đăng nhập" action="{url /demo/loginPost}">
						<frm.formItem type="user-defined" name="label" label="">
							<h2>Đăng nhập</h2>
							<a href="{url /demo/login}">Dành cho quản trị</a> |
							<a href="{url /student/login}">Dành cho phụ huynh</a> |
							<a href="{url /teacher/login}">Dành cho giáo viên</a>
							
						</frm.formItem>
						<frm.formItem name="username" required="true" validatebox="true" label="Tên đăng nhập" />
						<frm.formItem name="password" type="password" required="true" validatebox="true" label="Mật khẩu" />
						<frm.formItem name="send" type="submit" label="" />
					</frm.form>
				</block>
			</block>
		</block>
	</html.body>	
</page>