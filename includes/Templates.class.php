<?php
// <% %> 定界符 约定
// @变量引用 约定
// <% if %>
// <% endif %>

//加载解析器类
require ROOT_PATH . '/includes/Parser.class.php';

class Templates {
    private $_vars = array(); // 编译文件上下文环境
    private $_file; //待编译模板文件
    private $_varArray; //待注入的变量
    private $_tplFile;
    
    public function __construct() {
        if(!is_dir(TPL_DIR) || !is_dir(TPL_C_DIR) || !is_dir(CACHE_DIR)){
            exit('模板目录设置错误!');
        }
    }
    
    public function Render($_file, $varArray) {  
        $this->_file = $_file;
        $this->_varArray = $varArray;
        $this->_tplFile = TPL_DIR.$_file;
        $_tplFile = TPL_DIR.$_file;
        
        
        // 检测模板文件
        if (!file_exists($_tplFile)) {
            exit("找不到模板文件!");
        }
        
        // 生成/载入 待编译文件
        $_parFile = $this->genCompileFile();
        
        // 创建解析器对象,  并编译模板， 最后注入变量
        $_parser = new Parser($_tplFile);
        $_parser->compile($_parFile);
        $this->assign($varArray);

        //  若开启缓存，则加载缓存文件，否则直接加载编译文件
     $this->cacheUseCheck($_parFile);
     
    }
    
    private function genCompileFile() {
         // 生成or载入 待编译文件
        $_parFile = TPL_C_DIR . md5($this->_file) . $this->_file. '.php';
        if (!file_exists($_parFile) || filemtime($_parFile) < filemtime($this->_tplFile)) {
            file_put_contents($_parFile, file_get_contents($this->_tplFile));
        }
        return $_parFile;
    }
    
   
    private function cacheUseCheck($_parFile) {
        if (CACHE_OPEN) {
                //缓存文件
                $cache_file = CACHE_DIR . md5($this->_file) . $this->_file . '.html';
                
                //缓存文件不存在或编译文件改变，则重新生成缓存文件
                if (!file_exists($cache_file) || filemtime($cache_file) < filemtime($_parFile)) {
                        //引入缓存文件
                        include $_parFile;
                        $content = ob_get_clean(); //得到并清空当前输出缓存区
                        //生成缓存文件
                        if (!file_put_contents($cache_file, $content)) {
                                exit('缓存文件生成出错！');
                        }
                }
                //载入缓存文件
                include $cache_file;
        } 
        else {
                //载入编译文件
                include $_parFile;
        }         
    }
    
    //变量注入
    private function assign($array){
        
//        var_dump($array);
        
        foreach($array as $key => $value){
            if(isset($key)){
                $this->_vars[$key] = $value;
            }
            else{
                echo $key . '值为空，或未设置 </br>';
                exit();
            }
        }
    }
    
}