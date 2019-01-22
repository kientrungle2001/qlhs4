<?php 
/**
 * Function : Recursive
 * Author   : JosT
 * Date     : Dec 6, 2014
 */

	function buildArr($data, $columnName, $parentValue = 0)
	{
		recursive($data, $columnName, $parentValue, 1, $resultArr);
		return $resultArr;
	}
	
	function recursive($data,$columnName = "",$parentValue = 0, $lever = 1,&$resultArr)
	{
		if(count($data) > 0){
			foreach ($data as $key => $value) {
				if($value['parent'] == $parentValue){
					$value['lever'] = $lever;
					$resultArr[] = $value;
					$newParent = $value['id'];
					unset($data[$key]);
					recursive($data,$columnName,$newParent,$lever+1,$resultArr);
				}
			}
		}
	}

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $key1=>$element) {
            if ($element['parent'] == $parentId) {
                $children = buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    function show_menu($array = array())
    {
        echo '<ul class="drop">';
        foreach ($array as $item)
        {
            echo '<li>';
            echo '<a href="'.pzk_request()->build($item['router'].'/'.$item['id']).'"">';
            echo $item['name'];
            echo '</a>';
            if (!empty($item['children']))
            {
                show_menu($item['children']);
            }
            echo '</li>';
        }
        echo '</ul>';
    }

	function showAdminMenu($array = array()){
    	echo '<ul class="drop">';
        foreach ($array as $item){
        	$class_action = "";
        	if( pzk_session(MENU) === $item['admin_controller']){
        		$class_action = " class = 'action'";
        	}
            echo '<li'.$class_action.'>';
            if($item['admin_controller'] == '0'){
                echo '<a href="javarscript:void(0);">';
            }else {
                echo '<a href="/'.$item['admin_controller'].'/index">';
            }
            echo $item['name'];
            echo '</a>';
            if (!empty($item['children']))
            {
                showAdminMenu($item['children']);
            }
            echo '</li>';
        }
        echo '</ul>';
    }

    function getChilds($root_id, &$array_themes=array()) {//tham so la mang truyen vao, muon thao tac voi mang can them & dang truoc
        $this->load->model('catalog/category');
        $rootChild = $this->model_catalog_category->getCategories($root_id);
        if($rootChild){
            if(count($rootChild) > 0){
                foreach($rootChild as $key => $val) {
                    $array_themes[]=$val['category_id'];
                    $this->getChilds($val['category_id'], $array_themes);
                }
            }
        }
        return $array_themes;
    }

	function debug($data = array()){
		if($data){
			echo "<pre/>";
			print_r($data);
		}
	}
	
	function get_value_question_tyle($data = array(), $question_key){
		
		if(is_array($data)){
			
			foreach($data as $key	=> $value){
				
				if($question_key == $value['question_type']){
					
					return $value;
					
					break;
				}
			}
		}
		return false;
	}
    //ma hoa chuoi
    function encrypt($pure_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    /**
     * Returns decrypted original string
     */
    function decrypt($encrypted_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }
 ?>