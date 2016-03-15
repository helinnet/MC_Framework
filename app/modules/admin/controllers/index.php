<?php

class index extends SPS_Controller {
//    protected $services;
            function __construct($services) {
        parent::__construct($services);
    }
    public function index() {
            $this->services->view->test = 'test1';
            $this->services->view->test2 = 'test2';
            //dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. 'index'
            $this->services->view->render();
//        var_dump($this->services->dispatcher);
//        echo "here you are.";
    }
        public function test() {
            $this->services->view->test = 'test1';
            $this->services->view->test2 = 'test2';
            //dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. 'index'
            $this->services->view->render();
//        var_dump($this->services->dispatcher);
//        echo "here you are.";
    }


}
