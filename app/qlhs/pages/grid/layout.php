<div>
<easyui.layout.layout height="600px" width="100%">
	<!--easyui.layout.layout.north style="height:220px;">
		ABC
	</easyui.layout.layout.north-->
	<easyui.layout.layout.west style="width:200px;">
		<easyui.layout.accordion>
			<easyui.layout.tabpanel title="Tab 1">
				<easyui.grid.tree lines="true">
					<li>
						Menu item 1
						<ul>
							<li>1</li>
							<li>2</li>
						</ul>
					</li>
					<li>
						Menu item 2
						<ul>
							<li>1</li>
							<li>2</li>
						</ul>
					</li>
				</easyui.grid.tree>
			</easyui.layout.tabpanel>
			<easyui.layout.tabpanel title="Tab 2">
			D
			</easyui.layout.tabpanel>
		</easyui.layout.accordion>
	</easyui.layout.layout.west>
	<easyui.layout.layout.east style="width:200px;">
		IJK
	</easyui.layout.layout.east>
	<easyui.layout.layout.center style="width:200px; height: 200px;">
		<cms.menu>
			<li class="current">
				<a href="/">menu item 1</a>
				<ul>
					<li><a href="/">menu item</a></li>
					<li><a href="/">menu item</a></li>
					<li><a href="/">menu item</a></li>
					<li><a href="/">menu item</a></li>
					<li><a href="/">menu item</a></li>
				</ul>
			</li>
			<li>
				<a href="/">menu item 2</a>
			</li>
		</cms.menu>
	</easyui.layout.layout.center>
	<easyui.layout.layout.south style="height:200px;">
		<easyui.layout.tabs>
			<easyui.layout.tabpanel title="Tab 1">
			A
			</easyui.layout.tabpanel>
			<easyui.layout.tabpanel title="Tab 2">
			B
			</easyui.layout.tabpanel>
		</easyui.layout.tabs>
	</easyui.layout.layout.south>
</easyui.layout.layout>
</div>