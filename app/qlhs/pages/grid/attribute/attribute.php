<div id="right">
	<dg.dataGrid id="dg" title="Attribute Management" table="attribute_attribute" width="500px" height="450px">
		<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
		<dg.dataGridItem field="code" width="40">Code</dg.dataGridItem>
		<dg.dataGridItem field="title" width="150">Title</dg.dataGridItem>
		<layout.toolbar id="dg_toolbar">
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
		</layout.toolbar>
		<wdw.dialog gridId="dg" width="700px" height="auto" title="">
			<frm.form gridId="dg">
				<frm.formItem type="hidden" name="id" required="false" label="" />
				<frm.formItem name="title" required="true" label="Title" />
				<frm.formItem name="code" required="false" label="Code" />
				<frm.formItem name="scope" required="false" label="Scope" />
				<frm.formItem name="inputType" required="false" label="Input Type" />
				<frm.formItem name="defaultValue" required="false" label="Default Value" />
				<frm.formItem name="isUnique" required="false" label="Is Unique" />
				<frm.formItem name="isRequired" required="false" label="Is Required" />
				<frm.formItem name="validationType" required="false" label="Validation Type" />
			</frm.form>
		</wdw.dialog>
	</dg.dataGrid>
</div>