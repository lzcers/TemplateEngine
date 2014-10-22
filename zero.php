<?php
    class TemplateEngine {
        
        //模板引擎语法规定
        //@@****@@模板定界符约定 
        // @@ !var @@ 变量声明
        //
        // 仅测试可行性，直接生成静态html文件,不做缓存等
        // 1.输入*.Tpl模板文件 ----> 2.转换成字符串 ----> 3.根据定界符约定抽取内容 ----> 4. 按规则替换相应变量 
        //  ----> 5. 渲染并输出.html文件
        
        //模板文件
        private $TplFile = NULL;
        //匹配到的关键字
        private $MatchResult = NULL;
        //渲染结果
        private  $RenderResult = NULL;       
        
        function __Construct($Tpl)
        {
           $this->TplFile = $Tpl;
        }
        
        public function Rendered()
        {
            $this->Match();
            $this->Analy();
            return $this->MatchResult;
        }
        
        
        // 读取模板文件,并转换为字符串
        protected function OpenFileToStr()
        {
            $FileStr = file_get_contents($this->TplFile);
            return $FileStr;
        }
        
        //  抽取定界符中的类容
        protected function Match()
        {
            $pattern = "/@@\s*(?P<s>.*)\s*@@/"; 
            $RenderContent = $this->OpenFileToStr();
            preg_match_all($pattern, $RenderContent, $Result);
            $this->MatchResult= $Result['s'];
        }
       
        // 对定界符内字符进行判断
        protected function Analy()
        {
            // 考虑定界符内的内容
            // 普通变量
            // 逻辑语句
             $GeneralVar =array();
             $temp = NULL;
            foreach ($this->MatchResult as $value){
                // 普通变量的识别
                $Rgeneral = '/!(?P<s>\w+)/';
                preg_match($Rgeneral, $value, $temp);
                // 将需要替换的变量名推入generalVar数组
                array_push($GeneralVar, $temp['s']);
                print_r($GeneralVar);
            }
        }
        // 渲染
    }
    
    
    //  方法测试
    $test = new TemplateEngine('D:\tpltest.html');
    print_r($test->Rendered());
?>