<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityAttributeGroupModel extends PzkEntityModel {
	public $table = 'attribute_group';
	public function getAttributes() {
		$group_attributes = _db()->useCB()->select('attribute_attribute.*')->from('attribute_group_attribute')
			->join('attribute_attribute', array('equal', 
					array('column', 'attribute_group_attribute', 'attributeId'), 
					array('column', 'attribute_attribute', 'id')))
			->where(array('groupId', $this->get('id')))->result('attribute.attribute');
		return $group_attributes;
	}
}
