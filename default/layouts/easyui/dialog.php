<div id="dlg-{prop gridId}" class="easyui-dialog" style="width:{prop width};height:{prop height};padding:10px 20px; overflow: scroll-X;"
        closed="{prop closed}" buttons="#dlg-buttons-{prop gridId}">
    <span class="title">{prop title}</span><br />
	{children [className=PzkEasyuiFormForm]}
</div>
<div id="dlg-buttons-{prop gridId}">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="pzk.elements.{prop gridId}.save()">Save</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-{prop gridId}').dialog('close')">Cancel</a>
</div>