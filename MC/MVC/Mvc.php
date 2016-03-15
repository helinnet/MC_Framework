<?php
namespace MC\MVC;
Class Mvc {
protected $services;
protected $modulesDir;
protected $controllersDir;
protected $viewsDir;
protected $modelsDir;
protected $actionName;

function __construct($services){
if(!isset($services)){
throw new Exception('Please provide a services object!'); 
}
$this->services = $services;
//$this->modulesDir = ( $services->config->get('modulesDir') !== NULL ) ? $services->config->get('modulesDir') : $services->config->get('rootPath') .'appDir'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR;
$this->controllersDir = ($services->config->get('controllersDir') !== NULL ) ? $services->config->get('controllersDir') : $this->modulesDir .'controllers'.DIRECTORY_SEPARATOR;
$this->viewsDir = ( $services->config->get('viewsDir')  !== NULL ) ? $services->config->get('viewsDir') : $this->modulesDir .'views'.DIRECTORY_SEPARATOR;
$this->modelsDir = ($services->config->get('modelsDir') !== NULL ) ? $services->config->get('modelsDir') : $this->modulesDir .'models'.DIRECTORY_SEPARATOR;
} 

public function setModulesDir($modulesDir) {
        $this->modulesDir = $this->_setDirectory($modulesDir);
		return $this;
}
public function setControllersDir($controllersDir) {
        $this->controllersDir = $this->_setDirectory($controllersDir);
		return $this;
}
public function setModelsDir($modelsDir) {
        $this->modelsDir = $this->_setDirectory($modelsDir);
		return $this;
}
public function setViewsDir($viewsDir) {
        $this->viewsDir = $this->_setDirectory($viewsDir);
		return $this;
}
private function _setDirectory($d) {
        $dir = trim($d, '/\\');
        if (is_dir($dir) == false) {
                throw new Exception ('Invalid path: `' . $dir . '`');
        }
        return $dir . DIRECTORY_SEPARATOR;

}

     
}

