<?php
define('ROOT_PATH', dirname(__FILE__)); //  设置根目录
define('TPL_DIR',ROOT_PATH.'/templates/');  //模板文件目录
define('TPL_C_DIR',ROOT_PATH.'/templates_c/');  //编译文件目录
define('CACHE_DIR',ROOT_PATH.'/cache/');    //缓存目录
define('CACHE_OPEN', TRUE);
//  导入模板引擎
require ROOT_PATH . '/includes/Templates.class.php';

?>