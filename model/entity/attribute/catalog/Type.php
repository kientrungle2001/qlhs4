<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityAttributeCatalogTypeModel extends PzkEntityModel {
	public $table = 'attribute_catalog_type';
	public function getRelations() {
		return $this->getRelateds('attribute_catalog_type_relation', 'attribute.catalog.type.relation', 'typeId');
	}
}
