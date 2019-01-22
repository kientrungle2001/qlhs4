<div id="right">
	<dg.dataGrid id="dg" title="Group Attribute Management" table="attribute_group_attribute" width="500px" height="450px">
		<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
		<dg.dataGridItem field="setId" width="40">Set</dg.dataGridItem>
		<dg.dataGridItem field="groupId" width="40">Group</dg.dataGridItem>
		<dg.dataGridItem field="attributeId" width="150">Attribute</dg.dataGridItem>
		<layout.toolbar id="dg_toolbar">
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
		</layout.toolbar>
		<wdw.dialog gridId="dg" width="700px" height="auto" title="">
			<frm.form gridId="dg">
				<frm.formItem type="hidden" name="id" required="false" label="" />
				<frm.formItem name="setId" required="false" label="Attribute Set" />
				<frm.formItem name="groupId" required="false" label="Attribute Group" />
				<frm.formItem name="attributeId" required="false" label="Attribute" />
				<frm.formItem name="showAtListing" required="false" label="Show At Listing" />
			</frm.form>
		</wdw.dialog>
	</dg.dataGrid>
</div>