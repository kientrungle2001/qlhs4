<?php $set = $data->set;
$groups = $set->getGroups();
$attributes = $set->getAttributes();
$sets = _db()->select('*')->from('attribute_set')->orderBy('ordering asc')->result();
$fckeditors = array();
foreach($attributes as $attribute) {
	if($attribute->get('editingType') === 'fckeditor') {
		$fckeditors[] = $attribute->get('code');
	}
}
$fckeditors = implode(',', $fckeditors);
$comboboxs = array();
foreach($attributes as $attribute) {
	if($attribute->get('editingType') === 'combobox' && $attribute->get('multiple') === 'multiple') {
		$comboboxs[] = str_replace('[]', '', $attribute->get('code'));
	}
}
$comboboxs = implode(',', $comboboxs);
?>
<div>
{each $sets as $s}
	<a href="{url /attribute}/testSet?id={s[id]}">{s[title]}</a> |
{/each}
<dg.dataGrid id="dg" controller="/dset" title="<?php echo $set->get('title')?>" scriptable="true" 
	table="<?php echo $set->get('code')?>" width="800px" height="450px" fckeditors="{fckeditors}" multiselects="{comboboxs}">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<?php foreach($attributes as $attribute) { 
		if($attribute->get('showAtListing')) { 
	?>
	<dg.dataGridItem field="<?php echo $attribute->get('code')?>" width="120"><?php echo $attribute->get('title')?></dg.dataGridItem>	
	<?php
		}
		} ?>
	
	<?php 	
	$searchFields = array();
	foreach($attributes as $attribute) {
		if($attribute->get('filterable')) {
			$searchFields[] = "'" . $attribute->get('code') . "':'#dg_search [name=".$attribute->get('code')."]'";
		}
	}
	$searchFields = implode(', ', $searchFields);
	?>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search" onsubmit="pzk.elements.dg.search({'fields': {{searchFields}}}); return false;">
		<table>
		<?php 
		$filterCount = 0;
		foreach($attributes as $attribute) {
				if($attribute->get('filterable')) {
					$filterCount++;
					$attributebuilder = pzk_parse('<ide.builder.attribute />');
					$attributebuilder->attribute = $attribute;
					$attributebuilder->filterMode = true;
					$attributebuilder->display();
				}
			} ?>
		</table>
		<?php if($filterCount) { ?>
		<input type="submit" value="Tìm" />
		<?php } ?>
		</hform>
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="500px" title="<?php echo $set->get('title')?>">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<?php foreach($attributes as $attribute) { 
				$attributebuilder = pzk_parse('<ide.builder.attribute />');
				$attributebuilder->attribute = $attribute;
				$attributebuilder->display();
			} ?>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<?php if($set->get('code') == 'attribute_attribute') { ?>
<span>Thêm vào bảng: </span>
<form.combobox id="cmbSet" name="setId"
	sql="select id as value, 
			title as label from `attribute_set` order by id ASC"
		layout="category-select-list" />
<form.combobox id="cmbGroup" name="groupId"
	sql="select id as value, 
			title as label from `attribute_group` order by id ASC"
		layout="category-select-list" />
<layout.toolbarItem action="$dg.addToTable({url: '{url /dset/add}?table=attribute_group_attribute', 'gridField': 'attributeId', 'tableField': 'setId', 'tableFieldSource': '#cmbSet', 'tableField2': 'groupId', 'tableFieldSource2': '#cmbGroup'})" icon="add" />
<?php } ?>
</div>