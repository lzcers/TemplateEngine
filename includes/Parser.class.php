<?php
//  模板分析类

class Parser {
    private $_tpl;

    public function __construct($_tplFile) {
        if (!$this->_tpl = file_get_contents($_tplFile)){
            exit('模板读取错误');
        }
    }
    
    public function compile($_parFile) {
        //  解析普通变量
        $this->parVar();
        $this->parIf();
        if (!file_put_contents($_parFile, $this->_tpl)){
            exit('写入编译结果失败');
        }
    }
   
    
    private function parVar() { 
        $_patten='/\<%\s*@([\w]+)\s*%\>/';
//        preg_match_all($_patten, $this->_tpl, $result);
//        print_r($result);
            if (preg_match($_patten, $this->_tpl)){
                $this->_tpl = preg_replace($_patten, "<?php echo \$this->_vars['$1']; ?>", $this->_tpl);
        }
    }
    
    private function parIf() {
        $_patten_head = '/\<%\s*if\s*@([\w]+)\s*%\>/';
        $_patten_end = '/\<%\s*endif\s*%\>/';
//        preg_match_all($_patten_end, $this->_tpl, $result);
//        print_r($result);        
        // 查找头标签
        if (preg_match($_patten_head, $this->_tpl)) {
            // 且存在结束标签
            if (preg_match($_patten_end, $this->_tpl)) {
                // 满足条件，进行替换
                // 头替换
                $this->_tpl = preg_replace($_patten_head, "<?php if (\$this->_vars['$1']) { ?>", $this->_tpl);
                // 尾替换
                $this->_tpl = preg_replace($_patten_end, "<?php } ?>", $this->_tpl);
            }
            else {
                                exit('if 缺少结束标签');  
            }
        }
    }
    
   
}
    
    
