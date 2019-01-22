<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityAttributeCatalogTypeRelationModel extends PzkEntityModel {
	public $table = 'attribute_catalog_type_relation';
	public function getRelatedType() {
		return _db()->getEntity('attribute.catalog.type')->load($this->get('relatedId'));
	}
	public function getRelationType(){
		return _db()->getEntity('attribute.catalog.type')->load($this->get('relationTypeId'));
	}
	public function getAttribute() {
		return _db()->getEntity('attribute.attribute')->load($this->get('attributeId'));
	}
}
