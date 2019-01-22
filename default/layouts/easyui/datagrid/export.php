<div {attr id} class="easyui-dialog {prop class}" style="width:{prop width};height:{prop height};padding:10px 20px"
		closed="{prop closed}" buttons="#{prop buttons}"
		title="{prop title}"
		data-options="iconCls:'icon-redo',resizable:true,modal:true">
		<div id="tabs-{prop id}" class="easyui-tabs" style="width: <?php echo (intval($data->width) - 50)?>px; min-height: <?php echo (intval($data->height) - 100)?>px;">
			<div title="Chọn Định Dạng">
				<div style="padding-top: 50px;padding-bottom: 50px; text-align: center;">
					<select name="type">
						<option value="json">Chọn Định Dạng</option>
						<option value="json">JSON</option>
						<option value="csv">CSV</option>
						<option value="html">HTML</option>
						<option value="pdf">PDF</option>
						<option value="xlsx">XLSX</option>
						<option value="xml">XML</option>
					</select>
				</div>
			</div>
			<div title="Chọn Phạm Vi">
				<div style="padding-top: 50px;padding-bottom: 50px; text-align: center;">
					<select name="range">
						<option value="all">Chọn Phạm Vi</option>
						<option value="all">Tất cả</option>
						<option value="search">Theo bộ lọc</option>
						<option value="page">Trang hiện thời</option>
						<option value="selection">Lựa chọn</option>
					</select>
				</div>
			</div>
			<div id="fields-{prop id}" title="Chọn Trường Và Kiểu Dữ Liệu">
				<table border="1" style="border-collapse: collapse; width: 100%;">
					<tr>
						<th>id</th>
						<th>name</th>
						<th>phone</th>
						<th>email</th>
						<th>status</th>
					</tr>
					<tr>
						<td><input type="checkbox" checked /></td>
						<td><input type="checkbox" checked /></td>
						<td><input type="checkbox" checked /></td>
						<td><input type="checkbox" checked /></td>
						<td><input type="checkbox" checked /></td>
					</tr>
					<tr>
						<td>
							<input type="text" placeholder="id" />
						</td>
						<td>
							<input type="text" placeholder="name" />
						</td>
						<td>
							<input type="text" placeholder="phone" />
						</td>
						<td>
							<input type="text" placeholder="email" />
						</td>
						<td>
							<input type="text" placeholder="status" />
						</td>
					</tr>
					<tr>
						<td>
							<textarea placeholder="map for id"></textarea>
						</td>
						<td>
						<textarea placeholder="map for name"></textarea>
						</td>
						<td>
						<textarea placeholder="map for phone"></textarea>
						</td>
						<td>
						<textarea placeholder="map for email"></textarea>
						</td>
						<td>
						<textarea placeholder="map for status"></textarea>
						</td>
					</tr>
				</table>
			</div>
			<div title="Kết quả">
				<div style="padding-top: 50px; padding-bottom: 50px; text-align: center;" id="result-{prop id}">Nhấn nút hoàn thành để bắt đầu</div>
			</div>
		</div>
	{children all}
	<br />
	<div id="dlg-buttons-{prop id}">
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" 
				onclick="pzk.elements.{prop id}.startOver()">Bắt đầu</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-back" 
				onclick="pzk.elements.{prop id}.prev()">Quay lại</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-next"
				onclick="pzk.elements.{prop id}.next()">Tiếp tục</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" 
				onclick="pzk.elements.{prop id}.startExport()">Hoàn thành</a>
	</div>
</div>