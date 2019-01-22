<?php
/**
 *
 */
class PzkCategoryLesson extends PzkObject
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
    public function getEpcate() {
        $parent = _db()->useCB()->select('parent')->from($this->table)->where(array('id', $this->getParentCategoryId()))->result_one();
        $listCate = _db()->useCB()->select('*')->from($this->table)->where(array('parent',$parent['parent']))->result();
        return $listCate;
    }
}
?>