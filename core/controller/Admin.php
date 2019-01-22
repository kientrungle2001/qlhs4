<?php
class PzkAdminController extends PzkBackendController {
	public $table = false;
    public $childTable = false;
	public $masterStructure = 'admin/home/index';
	public $masterPosition = 'left';
	public $customModule = false;
	public function __construct() {
        parent:: __construct();//goi lop cha
		$controller = pzk_request('controller');
		$contrParts = explode('_', $controller);
		$this->module = $contrParts[1];
		if(!$this->table) {
			$this->table = $this->module;
		}
		
		$controller_name = pzk_request('controller');
		$menu =  pzk_session(MENU, $controller_name);

	}
	public function changeStatusAction() {
		$id = pzk_request()->getSegment(3);
		$entity = _db()->getTableEntity($this->table);
		$entity->load($id);
		$status = 1 - $entity->getStatus();
		$entity->update(array('status' => $status));
		$this->redirect('index');
	}
	public function changeOrderByAction() {
		pzk_session($this->table.'OrderBy', pzk_request('orderBy'));

		$this->redirect('index');
	}
    public function filterAction() {
        $type = pzk_request('type');
        pzk_session($this->table.$type.pzk_request('index'), pzk_request($type));

        $this->redirect('index');
    }

	public function changeCategoryIdAction() {
		pzk_session($this->table.'CategoryId', pzk_request('categoryId'));
		$this->redirect('index');
	}
	public function changeTypeAction() {
		pzk_session($this->table.'Type', pzk_request('type'));
		$this->redirect('index');
	}
	public function changeCategoryTypeAction() {
		pzk_session($this->table.'category_type', pzk_request('category_type'));
		$this->redirect('index');
	}
	public function changePageSizeAction() {
		pzk_session($this->table.'PageSize', pzk_request('pageSize'));
		$this->redirect('index');
	}
	public function searchPostAction() {
		$action	=	pzk_request('submit_action');
		if($action != ACTION_RESET){
			pzk_session($this->table.'Keyword', pzk_request('keyword'));
		}else{
			pzk_session($this->table.'Keyword', '');
			pzk_session($this->table.'Type', '');
			pzk_session($this->table.'CategoryId', '');
		}
		$this->redirect('index');
	}
    public function searchFilterAction() {
        $action	=	pzk_request('submit_action');
        if($action != ACTION_RESET){
            pzk_session($this->table.'Keyword', pzk_request('keyword'));
        }else{
            pzk_session($this->table.'Keyword', '');
            pzk_session($this->table.'OrderBy', '');
            $setting = pzk_controller();
            $fileds = $setting->filterFields;
            if(!empty($fileds)) {
                foreach($fileds as $val) {
                    pzk_session($setting->table.$val['type'].$val['index'],'');

                }
            }

        }
        $this->redirect('index');
    }
	public function indexAction() {
		$this->initPage()
		->append('admin/'.pzk_or($this->customModule, $this->module).'/index')
		->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right');
		$this->fireEvent('index.after', $this);
		$this->display();
	}
	
	public function addAction() {
		$this->initPage()
			->append('admin/'.pzk_or($this->customModule, $this->module).'/add')
			->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right')
			->display();
	}
	public function addPostAction() {
		$row = $this->getAddData();
		if($this->validateAddData($row)) {
            $row['createdId'] = pzk_session('adminId');
            $row['created'] = date(DATEFORMAT,time());
			$this->add($row);
			pzk_notifier()->addMessage('Thêm thành công');
			$this->redirect('index');
		} else {
			pzk_validator()->setEditingData($row);
			$this->redirect('add');
		}
	}
	public function getAddData() {
		return pzk_request()->getFilterData($this->addFields);
	}
	public function validateAddData($row) {
		return $this->validate($row, @$this->addValidator);
	}
	public function add($row) {
		$entity = _db()->getEntity('table')->setTable($this->table);
		$entity->setData($row);
		$entity->save();
	}
    public function editAllCatePostAction() {
        $row = $this->getEditData();
        $str = ','.implode(',', $row['categoryIds']).',';
        $row['categoryIds'] = $str;
        if($this->validateEditData($row)) {
            $this->edit($row);
            pzk_notifier()->addMessage('Cập nhật thành công');
            $this->redirect('index');
        } else {
            pzk_validator()->setEditingData($row);
            $this->redirect('edit/' . pzk_request('id'));
        }
    }
	public function editPostAction() {
		$row = $this->getEditData();
		if($this->validateEditData($row)) {
            $row['modifiedId'] = pzk_session('adminId');
            $row['modified'] = date(DATEFORMAT,time());
			$this->edit($row);
			pzk_notifier()->addMessage('Cập nhật thành công');
			$this->redirect('index');
		} else {
			pzk_validator()->setEditingData($row);
			$this->redirect('edit/' . pzk_request('id'));
		}
	}
	public function getEditData() {
		return pzk_request()->getFilterData($this->editFields);
	}
	public function validateEditData($row) {
		return $this->validate($row, @$this->editValidator);
	}
	public function edit($row) {
		$entity = _db()->getEntity('table')->setTable($this->table);
		$entity->load(pzk_request('id'));
		$entity->update($row);
		$entity->save();
	}
    public function importAction() {
        $this->initPage();
        $this->append('admin/'.pzk_or($this->customModule, $this->module).'/import')
            ->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right');
        $this->display();
    }
	public function editAction() {
		$module = pzk_parse(pzk_app()->getPageUri('admin/'.pzk_or($this->customModule, $this->module).'/edit'));
		$module->setItemId(pzk_request()->getSegment(3));
		$this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right')
			->display();
	}
	public function detailAction() {
		$module = pzk_parse(pzk_app()->getPageUri('admin/'.pzk_or($this->customModule, $this->module).'/detail'));
		$module->setItemId(pzk_request()->getSegment(3));
		$this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right');
		if($childList = pzk_element($this->module.'Children')){
			$childList->setParentId(pzk_request()->getSegment(3));
		}
		$this->display();
	}
	public function delAction() {
		$module = pzk_parse(pzk_app()->getPageUri('admin/'.pzk_or($this->customModule, $this->module).'/del'));
		$module->setItemId(pzk_request()->getSegment(3));
		$this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right')
			->display();
	}
	
	public function delPostAction() {

        if($this->childTable) {
            foreach($this->childTable as $val) {
                _db()->useCB()->delete()->from($val['table'])
                    ->where(array($val['findField'], pzk_request()->get('id')))->result();
            }

        }
        _db()->useCB()->delete()->from($this->table)
            ->where(array('id', pzk_request()->get('id')))->result();

		pzk_notifier()->addMessage('Xóa thành công');
		$this->redirect('index');
	}
    public function delAllAction() {
        if(pzk_request('ids')) {
            $arrIds = json_decode(pzk_request('ids'));
            if(count($arrIds) >0) {
                    _db()->useCB()->delete()->from($this->table)
                    ->where(array('in', 'id', $arrIds))->result();

                echo 1;
            }

        }else {
            die();
        }


    }
	public function uploadAction() {
		$this->initPage()
			->append('admin/'.pzk_or($this->customModule, $this->module).'/upload')
			->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right')
			->display();
	}
	public function uploadPostAction() {
		$row = $this->getUploadData();
        //debug($row);die();
		if($this->validateUploadData($row)) {
			$this->upload($row);
			pzk_notifier()->addMessage('Thêm thành công');
			$this->redirect('index');
		} else {
			pzk_validator()->setEditingData($row);
			$this->redirect('upload');
		}
	}
	public function getUploadData() {
		return pzk_request()->getFilterData($this->uploadFields);
	}
	public function validateUploadData($row) {
		return $this->validate($row, @$this->uploadValidator);
	}
	public function upload($row) {
		$entity = _db()->getEntity('table')->setTable($this->table);
		$entity->setData($row);
		$entity->save();
	}

    public function doUpload($filename, $dir, $allowed, $row) {
        if(isset($_FILES[$filename])) {
            if(!empty($_FILES[$filename]['name'])){
                // Kiem tra xem file upload co nam trong dinh dang cho phep
                if(in_array(strtolower($_FILES[$filename]['type']), $allowed)) {
                    // Neu co trong dinh dang cho phep, tach lay phan mo rong
                    $ext = end(explode('.', $_FILES[$filename]['name']));
                    $renamed = md5(rand(0,200000)).'.'."$ext";

                    if(move_uploaded_file($_FILES[$filename]['tmp_name'], $dir.$renamed)) {
                        if(!empty($row)) {
                            $row[$filename] = $renamed;
                            $id = pzk_request('id');
                            if(isset($id)) {
                                if($this->validateEditData($row)) {
                                    $data = _db()->useCB()->select('url')->from('video')->where(array('id', $id))->result_one();
                                    $url = BASE_DIR."/3rdparty/uploads/videos/".$data['url'];
                                    unlink($url);
                                    $this->edit($row);
                                    pzk_notifier()->addMessage('Cập nhật thành công');
                                    $this->redirect('index');
                                } else {
                                    pzk_validator()->setEditingData($row);
                                    $this->redirect('edit/' . pzk_request('id'));
                                }
                            }else {
                                if($this->validateAddData($row)) {
                                    $this->add($row);
                                    pzk_notifier()->addMessage('Thêm thành công');
                                    $this->redirect('index');
                                } else {
                                    pzk_validator()->setEditingData($row);
                                    $this->redirect('add');
                                }
                            }
                        }
                    } else {
                        $errors = "upload error";
                    }
                } else {
                    // FIle upload khong thuoc dinh dang cho phep
                    $errors = "File upload không thuộc định dạng cho phép!";
                    $this->redirect('index');
                }
            } else {
                if(!empty($row)) {
                    $id = pzk_request('id');
                    if(isset($id)) {
                        if($this->validateEditData($row)) {

                            $this->edit($row);
                            pzk_notifier()->addMessage('Cập nhật thành công');
                            $this->redirect('index');
                        } else {
                            pzk_validator()->setEditingData($row);
                            $this->redirect('edit/' . pzk_request('id'));
                        }
                    }else {
                        if($this->validateAddData($row)) {
                            $this->add($row);
                            pzk_notifier()->addMessage('Thêm thành công');
                            $this->redirect('index');
                        } else {
                            pzk_validator()->setEditingData($row);
                            $this->redirect('add');
                        }
                    }
                }
            } // END isset $_FILES



        }



        // Xoa file da duoc upload va ton tai trong thu muc tam
        if(isset($_FILES[$filename]['tmp_name']) && is_file($_FILES[$filename]['tmp_name']) && file_exists($_FILES[$filename]['tmp_name'])) {
            unlink($_FILES[$filename]['tmp_name']);
        }

        if(isset($errors)) {
            pzk_notifier_add_message($errors, 'danger');
        }

    }
	
}
