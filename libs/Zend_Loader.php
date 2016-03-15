<?php

class Zend_Loader {

    protected $config;
    protected $dirs = array();

    function __construct($services) {
        if (!isset($services)) {
            throw new Exception('Please provide service container object!');
        }
        $this->config = $services->get('config');
    }

    public function load() {
        spl_autoload_register(array($this, '_autoLoader'));
    }

    private function _autoLoader($file_name) {
        foreach ($this->dirs as $dir) {
            foreach (scandir($dir) as $file) {
                if ($file == $file_name .'.php') {
                    include $dir . $file;
                    break;
                }
            }
        }
    }

    public function setDir($key, $value) {
        if (isset($this->dirs[$key]) == true) {
            throw new Exception('Unable to register directory for `' . $key . '`. It is already set.');
        }
        if (!is_dir($value)) {
            throw new Exception($value . ' is not a directory.');
        }
        $this->dirs[$key] = $value;
        return $this;
    }

    public function getDirs() {
        $files = array();
        foreach ($this->dirs as $key => $dir) {
            foreach (scandir($dir) as $file) {
                if ($file != "." && $file != "..") {
                    $files[$key][] = $dir . $file;
                }
            }
        }
        return $files;
    }

}
