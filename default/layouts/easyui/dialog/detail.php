<div id="dlg-{prop gridId}" class="easyui-dialog" style="width:{prop width};height:{prop height};padding:10px 20px"
        closed="{prop closed}" buttons="#dlg-buttons-{prop gridId}">
    <div class="ftitle">{prop title}</div>
	{children all}
</div>
<div id="dlg-buttons-{prop gridId}">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="{prop onclick}">Save</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-{prop gridId}').dialog('close')">Cancel</a>
</div>