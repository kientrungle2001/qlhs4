<?php
class PzkGridAdminController extends PzkAdminController {
	public $masterStructure = 'admin/home/index';
	public $masterPosition = 'left';
	public $customModule = 'grid';
	public $table = false;
    public $joins = false;
    public $selectFields = '*';
    public $childTable = false;
    public $setAddTabs = false;
    public $setEditTabs = false;
    public $filterFields = false;
    public $menuLinks = false;
    public $listSettingType = false;
	public $listFieldSettings = array();
	public $addLabel = 'Thêm bản ghi';
	public $addFieldSettings = array();
	public $editFieldSettings = array();
	public $searchFields = array();
    public $Searchlabels = false;
	public $filterFieldSettings = array();
	public $sortFields = array();
    public $exportFields = false;
    public $exportTypes = false;
    public $importFields = false;
    public $titleController = false;
    public $editLabel = false;
	public $events = array(
		'index.after' => array('this.indexAfter'),

	);
	public function append($obj, $position = NULL) {
		$obj = $this->parse($obj);
		$obj->setTable($this->table);
		return parent::append($obj, $position);
	}
	public function indexAfter($event, $data) {
		$list = pzk_element('list');
		if($list) {
			$list->addEventListener('changeStatus', 'onChangeStatus');
		}
	}


	
	public function onChangeStatusAction() {
		$id = pzk_request('id');
		$field = pzk_request('field');
		if(!$field) $field = 'status';
		$entity = _db()->getTableEntity($this->table)->load($id);
		$status = 1 - @$entity->data[$field];
		$entity->update(array($field => $status));
		if($entity->data[$field] == '1') {
			//jQuery('#status-' . $id)->html('Hoạt động')->display();
		} else {
			//jQuery('#status-' . $id)->html('Không hoạt động')->display();
		}
	}

    public function importPostAction() {
        $username = pzk_session('adminUser');
        if(isset($username)) {
            $username = pzk_session('adminUser');
        }else {
            die();
        }
        $setting = pzk_controller();
        if(empty($setting->importFields)){
            die();
        }

        if(isset($_GET['token'])){
            $token = $_GET['token'];
        }else {
            die();
        }
        if(isset($_GET['time'])){
            $time = $_GET['time'];
        }else{
            die();
        }

        if ($token == md5( $time . $username . 'onghuu' ) ) {
            //upload
            if(!empty($_FILES['file']['name'])){
                $allowed = array('csv','xlsx','xls');
                $dir = BASE_DIR."/tmp/";
                $fileParts = pathinfo($_FILES['file']['name']);
                // Kiem tra xem file upload co nam trong dinh dang cho phep
                if(in_array($fileParts['extension'], $allowed)) {
                    // Neu co trong dinh dang cho phep, tach lay phan mo rong
                    $tam = explode('.', $_FILES['file']['name']);
                    $ext = end($tam);
                    $renamed = md5(rand(0,200000)).'.'."$ext";

                    move_uploaded_file($_FILES['file']['tmp_name'], $dir.$renamed);
                } else {
                    // FIle upload khong thuoc dinh dang cho phep
                    die("File upload không thuộc định dạng cho phép!");
                }
            }

            //load file
            $path = $dir.$renamed;
            if(!file_exists($path)) {
                die('file not exist');
            }
            require_once BASE_DIR . '/3rdparty/phpexcel/PHPExcel.php';

            $host = _db()->host;
            $user = _db()->user;
            $password = _db()->password;
            $db = _db()->dbName;
            //connect database
            $dbc = mysqli_connect($host, $user,$password,$db);

            if(!$dbc) {
                trigger_error("Could not connect to DB: " . mysqli_connect_error());
            } else {
                mysqli_set_charset($dbc, 'utf8');
            }

            $objPHPExcel = PHPExcel_IOFactory::load($path);

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++){
                //  Read a row of data into an array
                $rowData = $sheet->toArray('A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE);

            }
            $table = mysqli_real_escape_string($dbc, $setting->table);
            $importFields = implode(',', $setting->importFields);
            $cols = mysqli_real_escape_string($dbc, $importFields);
            $arrfields = explode(',', $importFields);

            unset($rowData[0]);
            //combine array
            if($rowData) {
                foreach($rowData as $item) {
                    $arrWhere[] = array_combine($arrfields, $item);
                }

                $where = '';
                foreach($arrWhere as $item) {
                    foreach($item as $key => $val) {
                        $val = @mysql_escape_string($val);
                        $where .= "$key = " ."'$val'". " AND ";
                    }
                    $where = substr($where, 0, -4);
                    $sql = "SELECT id from {$table} WHERE {$where}";
                    $result = mysqli_query($dbc, $sql);
                    if (mysqli_errno($dbc)) {
                        $message = 'Invalid query: ' . mysqli_error($dbc) . "\n";
                        $message .= 'Whole query: ' . $sql;
                        die($message);
                    }
                    $row = mysqli_fetch_assoc($result);
                    if($row) {
                        $vals = array();
                        foreach ($item as $key => $value) {
                            $vals[] = '`'.$key . '`=\'' . @mysql_escape_string($value) . '\'';
                        }
                        $values = implode(',', $vals);
                        $sql = "update {$table} set $values where id = ".$row['id']."";
                        mysqli_query($dbc, $sql);
                        if (mysqli_errno($dbc)) {
                            $message = 'Invalid query: ' . mysqli_error($dbc) . "\n";
                            $message .= 'Whole query: ' . $sql;
                            die($message);
                        }
                    }else {

                        $columns = explode(',', $cols);
                        $list = '';
                        foreach($columns as $col) {
                            $col = trim($col);
                            $col = str_replace('`', '', $col);
                            $list .= ','."'".@mysql_escape_string($item[$col])."'";
                        }
                        $list = substr($list,1);
                        $sql = "INSERT INTO {$table}($cols)  VALUES ($list)";
                        mysqli_query($dbc, $sql);
                        if (mysqli_errno($dbc)) {
                            $message = 'Invalid query: ' . mysqli_error($dbc) . "\n";
                            $message .= 'Whole query: ' . $sql;
                            die($message);
                        }

                    }
                    $where = '';
                }
            }
            if(file_exists($path)) {
                unlink($path);
            }
            $url ="/admin_".$setting->module."/index";
            pzk_notifier_add_message('Import thành công!', 'success');
            header("location: $url");
            exit;
        }
    }

    public function highchartAction() {
        $this->initPage();
        $this->append('admin/'.pzk_or($this->customModule, $this->module).'/highchart')
            ->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right');
        $this->display();
    }
}