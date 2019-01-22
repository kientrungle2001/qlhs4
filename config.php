<?php
// Bat thong bao loi;
ini_set('error_reporting', E_ALL);
session_start();
/**
 * @desc Quyền truy cập vào file php
 * @var integer
 */
define('PZK_ACCESS', 1);

/**
 * @desc Thư mục hệ thống
 * @var string
 */
define('SYSTEM_DIR', dirname(__FILE__));

/**
 * @desc Thư mục gốc
 * @var string
 * @see SYSTEM_DIR
 */
define('BASE_DIR', SYSTEM_DIR);

/**
 * @var string
 * @desc Đường dẫn gốc
 */
define('BASE_URL', "http://{$_SERVER['HTTP_HOST']}");

/**
 * @desc Chế độ REWRITE
 * @var boolean
 */
define('REWRITE_MODE', false);


if(REWRITE_MODE) {	
	define('BASE_REQUEST', "http://{$_SERVER['HTTP_HOST']}");
} else {
    /**
     *  @desc Đường dẫn chạy request gốc có chứa index.php
     *  @var string
     */
    define('BASE_REQUEST', "http://{$_SERVER['HTTP_HOST']}/index.php");
}

/**
 * @desc Chế độ SEO, đường dẫn thân thiện
 * @var boolean
 */
define('SEO_MODE', false);

// them include path
set_include_path(get_include_path() . BASE_DIR . ';');

/**
 * @desc Chế độ CACHE
 */
define('PZK_CACHE', true);

//	MENU
define('MENU', 'MENU');

//	SEARCH
define('ACTION_SEARCH', '1');

define('ACTION_RESET', '0');

//	QUESTION TYPE

define('QUESTION_WORDS',	'Dạng về từ');
define('QUESTION_PHRASE',	'Dạng về câu');
define('QUESTION_PASSAGE',	'Dạng bài về đoạn văn');
define('QUESTION_CITATION',	'Dạng bài về bài văn');

//	FORMAT DATE
/**
 * @desc Định dạng ngày tháng cho insert vào database
 */
define('DATEFORMAT',	'Y-m-d H:i:s');

if(!function_exists('mysql_escape_string')) {
    /**
     * @desc Escape một chuỗi mysql
     * @param string $inp Chuỗi chưa escape
     * @return string chuỗi đã escape
     */
    function mysql_escape_string($inp) { 
        if(is_array($inp)) 
            return array_map(__METHOD__, $inp); 
    
        if(!empty($inp) && is_string($inp)) { 
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
        } 
    
        return $inp; 
    }
}
