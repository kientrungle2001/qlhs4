<?php
pzk_loader()->importObject('core/db/List');
/**
 *
 */
class PzkCategoryQuestion extends PzkCoreDbList
{
    public $parentCategoryId;
    public function listQuestion()
    {
        $listQuestion = _db()->select('*')->from($this->table)->result();
        return $listQuestion;
    }
    public function listAnswer()
    {
        $listAnswer = _db()->select('*')->from('answers')->result();
        return $listAnswer;
    }
    public function getQuestionByIds($ids, $level,$limit=5) {
        $data = _db()->useCB()->select('*')->from($this->table)
            ->where(array('and', array('like', 'categoryIds', '%'.$ids.'%'), array('level', $level)) )
            ->orderby('rand()')
            ->limit($limit, 0)->result();
        return $data;
    }

}
?>