<?php
$attribute = $data->attribute;
$attributeTypes = array('hidden', 'text', 'password', 'number', 'date', 'email', 'range', 'color', 'datetime', 'time', 'url', 'month', 'week');
if(in_array($attribute->get('editingType'), $attributeTypes)) {
	echo '<frm.formItem type="'.$attribute->get('editingType').'" name="'.$attribute->get('code').'" '.($attribute->get('required', 'false') == 'true' ? 'required="true"': '').' validatebox="'.$attribute->get('validatebox', 'false').'" label="'.$attribute->get('title').'" />';
} else {
	$editingType = $attribute->get('editingType');
	if($editingType) {
		$rs = '<frm.formItem type="user-defined" label="'.$attribute->get('title').'">';
		switch($editingType) {
			case 'combobox':
			$rs .= '<form.combobox id="'.str_replace('[]', '', $attribute->get('code')) . (@$data->filterMode ? '-filter' : '' ) .'" name="'.$attribute->get('code') . (@$data->filterMode ? '' : ($attribute->get('multiple', '')=='multiple' ? '[]' : '')) . '" multiple="'. (@$data->filterMode ? '' : $attribute->get('multiple', '')) .'"
							'.($attribute->get('dependence') ? 'dependence="'.$attribute->get('dependence').'" ':'').'
							'.($attribute->get('dependenceField') ? 'dependenceField="'.$attribute->get('dependenceField').'" ':'').'
							sql="select '.$attribute->get('valueField', 'id').' as value, 
									'.$attribute->get('labelField', 'name').' as label' . ($attribute->get('dependenceField') ? ','.$attribute->get('dependenceField'):'') 
									. ' from `'.$attribute->get('sourceTable', 'classes').'` where ' . $attribute->get('conds', '1') 
									.($attribute->get('type') ? ' and `type`=\''.$attribute->get('type').'\' ':'')
									. ' order by '.$attribute->get('orderBy', 'name asc').'"
								layout="category-select-list" />';
			break;
			case 'fckeditor': 
			$rs .= '<form.fckEditor id="'.$attribute->get('code').'" name="'.$attribute->get('code').'" width="'.$attribute->get('width', '400px').'" height="'.$attribute->get('height', '300px').'" />';
			break;
			case 'yesno':
			$rs .= '<select name="'.$attribute->get('code').'"><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>';
			break;
		}
		$rs .= '</frm.formItem>';
		echo $rs;
	}
}