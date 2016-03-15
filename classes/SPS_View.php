<?php

Class SPS_View {

    protected $services;
    protected $variables = array();
    protected $viewFile;
    protected $layoutFile;
    protected $themesFile;

    function __construct($services) {
        if (!isset($services)) {
            $this->services->logger->log('  Please provide a service container object!  ');
            throw new Exception('Please provide a service container object!');
        }
         $this->services = $services;
        $this->viewFile = $this->services->config->modulesDir . $this->services->dispatcher->moduleName . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->services->dispatcher->controllerName . DIRECTORY_SEPARATOR . $this->services->dispatcher->actionName . '.php';
        $this->services->view = $this;
        $this->set('controller', $this->services->dispatcher->moduleName);
        $this->set('module', $this->services->dispatcher->controllerName);
        $this->set('action', $this->services->dispatcher->actionName);
    }

    public function setThemesFile($file) {
        $this->themesFile = $file;
        return $this;
    }

    public function setLayoutFile($file) {
        $this->layoutFile = $file;
        return $this;
    }

    public function setViewFile($file) {
        $this->viewFile = $file;
        return $this;
    }

    public function render($level = 'themes') {
        if ($level == 'themes') {
            $this->getThemesContent();
        }
        if ($level == 'layout') {

            $this->getLayoutContent();
        }
        if ($level == 'view') {
            $this->getViewContent();
        }
    }

    public function getViewContent($path = NULL, $variables = array()) {
        if (!empty($variables)) {
            $this->variables = $variables;
        }
        // Load variables
        foreach ($this->variables as $key => $value) {
            $$key = $value;
        }


        if (empty($path)) {
            include ($this->viewFile);
        } else {
            if (!file_exists($path)) {
                throw new Exception('View `' . $path . '` does not exist.');
            }
            include ($path);
        }
    }

    public function getLayoutContent($path = NULL, $variables = array()) {
        if (!empty($variables)) {
            $this->variables = $variables;
        }
        // Load variables
        foreach ($this->variables as $key => $value) {
            $$key = $value;
        }


        if (empty($path)) {
            include ($this->layoutFile);
        } else {
            if (!file_exists($path)) {
                throw new Exception('View `' . $path . '` does not exist.');
            }
            include ($path);
        }
    }

    public function getThemesContent($path = NULL, $variables = array()) {
        if (!empty($variables)) {
            $this->variables = $variables;
        }
        // Load variables
        foreach ($this->variables as $key => $value) {
            $$key = $value;
        }


        if (empty($path)) {
            include ($this->themesFile);
        } else {
            if (!file_exists($path)) {
                throw new Exception('View `' . $path . '` does not exist.');
            }
            include ($path);
        }
    }

    public function __set($key, $value) {
        if (isset($this->variables[$key]) == true) {
            throw new Exception('Unable to set value `' . $key . '`. it is already set.');
        }
        $this->variables[$key] = $value;
        return $this;
    }

    public function __get($key) {
        if (isset($this->variables[$key]) == false) {
            return null;
        }
        return $this->variables[$key];
    }

    public function set($key, $value) {
        if (isset($this->variables[$key]) == true) {
            throw new Exception('Unable to set value `' . $key . '`. it is already set.');
        }
        $this->variables[$key] = $value;
        return $this;
    }

    public function get($key) {
        if (isset($this->variables[$key]) == false) {
            return null;
        }
        return $this->variables[$key];
    }

    public function getAll() {
        return $this->variables;
    }

    public function remove($key) {
        unset($this->variables[$key]);
        return $this;
    }

}