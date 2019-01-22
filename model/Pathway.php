<?php
class PathwayModel {
	public function getItems($paths) {
		return _db()->select('id,alias,title')->from('route')->where(array('alias' => $paths))->result();
	}
}
?>