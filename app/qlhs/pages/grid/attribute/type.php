<div id="right">
	<dg.dataGrid id="dg" title="Attribute Type" table="attribute_type" width="500px" height="450px">
		<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
		<dg.dataGridItem field="code" width="40">Code</dg.dataGridItem>
		<dg.dataGridItem field="title" width="150">Title</dg.dataGridItem>
		<layout.toolbar id="dg_toolbar">
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
		</layout.toolbar>
		<wdw.dialog gridId="dg" width="700px" height="auto" title="Attribute Type">
			<frm.form gridId="dg">
				<frm.formItem type="hidden" name="id" required="false" label="" />
				<frm.formItem name="title" required="true" label="Title" />
				<frm.formItem name="code" required="false" label="Code" />
			</frm.form>
		</wdw.dialog>
	</dg.dataGrid>
</div>