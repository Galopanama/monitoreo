<?php

// load Smarty library from this same directory
require_once dirname(__FILE__) . '/Smarty.class.php';

class MySmarty extends Smarty {

   function __construct()
   {

        // Class Constructor.
        // These automatically get set with each new instance.

        parent::__construct();

        $this->setTemplateDir(_ROOT_PATH_ . '/tpl/');
        $this->setCompileDir(_ROOT_PATH_ . '/tpl/smarty/templates_c/');
        $this->setConfigDir(_ROOT_PATH_ . '/tpl/smarty/configs/');
        $this->setCacheDir(_ROOT_PATH_ . '/tpl/smarty/cache/');
   }

}
