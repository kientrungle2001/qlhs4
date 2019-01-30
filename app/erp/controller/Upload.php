<?php
class PzkUploadController extends PzkController {
	public function postAction() {
		$filename = $_FILES['file']['name'];
		$fileType = $_FILES['file']['type'];
		$fileError = $_FILES['file']['error'];
		$fileContent = file_get_contents($_FILES['file']['tmp_name']);

		if($fileError == UPLOAD_ERR_OK){
			//Processes your file here
			move_uploaded_file($_FILES["file"]["tmp_name"],
			BASE_DIR . "/cache/" . $filename);
			$message = 'Upload thành công';
			echo json_encode(array(
				'error' => false,
				'message' => $message,
				'file'	=> '/cache/'.$filename,
				'path' => '/cache/'.$filename	
				));
		}else{
			switch($fileError){
				case UPLOAD_ERR_INI_SIZE:	
				$message = 'Lỗi khi cố tải lên một tệp vượt quá kích thước cho phép.';
				break;
				case UPLOAD_ERR_FORM_SIZE:  
				$message = 'Lỗi khi cố tải lên một tệp vượt quá kích thước cho phép.';
				break;
				case UPLOAD_ERR_PARTIAL:	
				$message = 'Lỗi: hành động tải lên tệp không được hoàn thành.';
				break;
				case UPLOAD_ERR_NO_FILE:	
				$message = 'Lỗi: không có tệp nào được tải lên';
				break;
				case UPLOAD_ERR_NO_TMP_DIR: 
				$message = 'Lỗi: máy chủ không được cấu hình để tải lên tập tin.';
				break;
				case UPLOAD_ERR_CANT_WRITE: 
				$message= 'Lỗi: có thể thất bại khi ghi tập tin.';
				break;
				case  UPLOAD_ERR_EXTENSION: 
				$message = 'Lỗi: tải lên tập tin không hoàn thành.';
				break;
				default: $message = 'Lỗi: tải lên tập tin không hoàn thành.';
					break;
			}
			echo json_encode(array(
			'error' => true,
			'message' => $message
			));
		}
	}
}