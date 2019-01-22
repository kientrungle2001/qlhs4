<?php
class PzkVisitor extends PzkObject {
	public $timeframe = 10;
	public $onlinenow = 0;
	public $layout = "visitor";
	public function init() {
		// On to the counter processing... 
		$vis_ip = ip2long ( $_SERVER [ 'REMOTE_ADDR' ]); 

		$time = time (); 
		$new_vis = 1 ; 
		$get_ip = db_get ( "SELECT * FROM visits WHERE vis_ip=" . $vis_ip . " LIMIT 1" ); 
		if ($get_ip) {
			_db()->update('visits')->set(array('vis_time' => $time))
				->where(array('vis_ip' => $vis_ip));
			$new_vis = 0 ;
		}
		
		if ( $new_vis == 1 ) 
		{
			_db()->insert('visits')->values(array(
				array('vis_ip' => $vis_ip, 'vis_time' => $time)));
		}
		
		$tcheck = $time - ( 60 * $this->timeframe ); 
		$this->onlinenow = db_count ( "visits", "vis_time > $tcheck"); 
	}
	
}
?>