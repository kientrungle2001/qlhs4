<?php
class PzkGalleryShowgallery extends PzkObject
{

		public function getGallery()
		{
			$gallerys=_db()->useCB()->select("*")->from("gallery")->result();
			return($gallerys);
		}
		public function getSubgallery($id)
		{
			$image=_db()->useCB()->select("*")->from("gallery_img")->where(array('galleryId',$id))->limit(1)->result();
			return($image);
		}
		
}

?>