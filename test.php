<?php
require 'tpleconf.php';
$_tpl = new Templates();
$_name1 = '模板引擎';
$_name2 = '内容输出';
$_name3 = 1;
$_tpl->Render('index.tpl', array('name1' => $_name1,  'name2' => $_name2, 'aa' => $_name3));
