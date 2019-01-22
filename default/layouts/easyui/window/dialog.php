<div id="{prop id}" class="easyui-dialog" style="width:{prop width};height:{prop height};padding:10px 20px"
        closed="{prop closed}" buttons="#{prop buttons}"
        title="{prop title}">
	{children all}
        <div id="dlg-buttons-{prop gridId}">
                <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="pzk.elements.{prop gridId}.save()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-{prop gridId}').dialog('close')">Cancel</a>
        </div>
</div>