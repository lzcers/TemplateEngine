<body>
    模板引擎测试：</br>
    title: <?php echo $this->_vars['name1']; ?> </br>
    content: <?php echo $this->_vars['name2']; ?> </br>
    <?php if ($this->_vars['aa']) { ?>
        <p>if 测试!</p>
    <?php } ?>
</body>