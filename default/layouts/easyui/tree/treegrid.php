<table id="{prop id}" class="easyui-treegrid" title="{prop title}" style="width:{prop width};height:{prop height}"
	toolbar="#{prop id}_toolbar" pagination="{prop pagination}"
            rownumbers="{prop rownumbers}" fitColumns="{prop fitColumns}" 
			singleSelect="{prop singleSelect}" collapsible="{prop collapsible}" 
			url="{prop url}" method="{prop method}" multiSort="{prop multiSort}"
			 data-options=" pageSize: 20, pageList: [2,10,20],idField: 'id', treeField: '{prop treeField}'">
	<thead>
		<tr>
			{children [className=PzkEasyuiDatagridDataGridItem]}
		</tr>
	</thead>
</table>
{children [className=PzkEasyuiLayoutToolbar]}
{children [className=PzkEasyuiWindowDialog]}