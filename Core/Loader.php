<?php
namespace MC\Core;
class Loader {
    /**
     * Directories to auto load
     * @var array
     */
    protected $dirs = array();
/**
 * Register custom auto Loader
 */
    public function autoLoad() {
        spl_autoload_register(array($this, '_autoLoader'));
    }
/**
 * A custom auto Loader function
 * @param string $file_name
 */
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
/**
 * Set a directory in order to auto load
 * @param string $key
 * @param type $value
 * @return \MC\Core\Loader
 * @throws Exception or @return $this Loader
 */
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
/**
 * get all registered directories in auto loaders
 * @return string
 */
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
