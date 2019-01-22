<?php
// tắt thông báo lỗi
error_reporting(0);
ob_start();
// cài đặt timezone mặc định
date_default_timezone_set('Asia/Ho_Chi_Minh');

// định dạng document theo utf8
mb_language('uni');
mb_internal_encoding('UTF-8');

// cấu hình
require_once 'config.php';

// khai báo các thư viện cần để chạy hệ thống
require_once 'include.php';

// đọc file hệ thống
$sys = pzk_parse('system/full');

// chạy ứng dụng từ hệ thống
$app = $sys->getApp();
$app->run();