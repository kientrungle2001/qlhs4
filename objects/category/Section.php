<?php
/**
 *
 */
class PzkCategorySection extends PzkObject
{
    public $parentCategoryId;
    public function listCate()
    {
        $listCate = _db()->select('*')->from($this->table)->result();
        return $listCate;
    }
    public function getCateByParent() {
        $listCate = _db()->useCB()->select('*')->from($this->table)->where(array('parent', $this->getParentCategoryId()))->result();
        return $listCate;
    }
}
?>