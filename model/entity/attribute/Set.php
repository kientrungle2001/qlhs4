<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityAttributeSetModel extends PzkEntityModel {
	public $table = 'attribute_set';
	public function getGroups() {
		return $this->getRelateds('attribute_group', 'attribute.group', 'setId');
	}
	public function getAttributes() {
		$attributes = _db()->useCB()->select('attribute_attribute.*')
			->from('attribute_group_attribute')
			->join('attribute_attribute', array('equal', 
					array('column', 'attribute_group_attribute', 'attributeId'), 
					array('column', 'attribute_attribute', 'id')))
			->where(array('setId', $this->get('id')))->orderBy('attribute_group_attribute.ordering asc')->result('attribute.attribute');
		$set = _db()->useCB()->select('*')->from('attribute_group_attribute')
				->where(array('setId', $this->get('id')))->orderBy('attribute_group_attribute.ordering asc')->result();
		$attributesInSet = array();
		foreach($set as $attribute) {
			unset($attribute['id']);
			$attributesInSet[$attribute['attributeId']] = $attribute;
		}
		foreach($attributes as &$attribute) {
			$attributeInSet = $attributesInSet[$attribute->get('id')];
			foreach($attributeInSet as $key => $value) {
				if($value !== '') {
					$attribute->set($key, $value);
				}
			}
		}
		return $attributes;
	}
}
