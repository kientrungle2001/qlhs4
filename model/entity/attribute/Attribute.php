<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityAttributeAttributeModel extends PzkEntityModel {
	public $table = 'attribute_attribute';
	public function getGroups() {
		return $this->getRelateds('attribute_group', 'attribute.group', 'attributeSetId');
	}
}
