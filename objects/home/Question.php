<?php
	class PzkHomeQuestion extends PzkObject
	{
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
	}
 ?>