<?php
class PzkGalleryThumbnailgallery extends PzkObject
{
		public function getSubgallery($id)
		{
			$image=_db()->useCB()->select("*")->from("gallery_img")->where(array('galleryId',$id))->result();
			return($image);
		}
		
}

?>