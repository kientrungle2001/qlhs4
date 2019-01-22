<core.application id="app" name="erp" dispatcher="ControllerBased" 
	gsv="DJBoN802jfeoHdZJX1oM0vqdSuVjiqQ_0t4dHq0zEf4">
	<core.database.arrayCondition id="conditionBuilder" />
	<core.database id="db" host="localhost" user="root" password="123456" dbName="erp"></core.database>
	<core.shorty name="dg" value="easyui.datagrid" />
	<core.shorty name="frm" value="easyui.form" />
	<core.shorty name="layout" value="easyui.layout" />
	<core.shorty name="wdw" value="easyui.window" />
	<core.config.db id="config" />
	<core.rewrite.request pattern="^\/([*controller*][\w_][\w\d_]*)[\/]?$" queryParams="controller" defaultQueryParams='{"action": "index"}' />
	<core.rewrite.request pattern="^\/([*controller*][\w_][\w\d_]*)\/([*action*][\w_][\w\d_]*)" queryParams="controller, action" />
	<core.rewrite.permission id="permission" login="account/login" success="home/index" />
</core.application>
