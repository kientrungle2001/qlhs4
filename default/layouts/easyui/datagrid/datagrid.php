<table class="easyui-datagrid" style="width:{prop width};height:{prop height}"
	toolbar="#{prop id}_toolbar"
			{attrs id, title, pageSize, pageNumber, rownumbers, fitColumns, singleSelect, collapsible, url, method, multiSort, rowStyler, nowrap, pagination, sortName, sortOrder, showHeader, showFooter, scrollbarSize, rownumberWidth, editorHeight, loader, loadFilter, editors, view}
			data-options="<?php if(@$data->noClickRow != 'true') { ?>onClickRow:function() {
				if(pzk.elements.{prop id}.singleSelect == 'true') {
					var code = $('#{prop id}_toolbar [iconcls=icon-sum]:first').attr('href') || ''; 
					eval(code.replace('javascript:', ''));
				}
			}<?php } elseif(@$data->onClickRow) { ?>onClickRow:<?php echo $data->onClickRow?><?php } ?>">
	<thead>
		<tr>
			{children [className=PzkEasyuiDatagridDataGridItem]}
		</tr>
	</thead>
</table>
{children [className=PzkEasyuiLayoutToolbar]}
{children [className=PzkEasyuiWindowDialog]}
