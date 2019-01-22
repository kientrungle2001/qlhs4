<?php
pzk_loader()->importObject('core/db/List');
/**
 *
 */
class PzkCategorySuccess extends PzkCoreDbList
{
    public $parentCategoryId;
    public function listQuestion()
    {
        $listQuestion = _db()->select('*')->from($this->table)->result();
        return $listQuestion;
    }
    public function countTrue( $answerId) {
        $data = _db()->useCB()->select('*')->from('answers')
            ->where(array('and', array('valueTrue', 1), array('id', $answerId)) )->result();
        $total = count($data);
        return $total;
    }

}
?>