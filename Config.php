<?php
namespace MC\Core;
class Config {
/**
 * @var array
 */
    protected $settings = array();
/**
 * Set a config item
 * @param string $key
 * @param string $value
 * @return \SPS_Config
 * @throws Exception
 */
    public function __set($key, $value) {
        if (isset($this->settings[$key])) {
            throw new Exception('Unable to set value of the `' . $key . '`. it is already set.');
        }
        $this->settings[$key] = $value;
        return $this;
    }
/**
 * Get a config item
 * @param string $key
 * @return null or value of the @param string $key
 */
    public function __get($key) {
        if (!isset($this->settings[$key])) {
            return false;
        }
        return $this->settings[$key];
    }
/**
 *
 * @return all config items
 */
    public function getConfig() {
        return $this->settings;
    }
/**
 * Set the config array via parameter
 * @param array $array
 * @return \SPS_Config
 * @throws Exception or set the settings array via @param array $array
 * @return \SPS_Config
 */
    public function setConfig($array) {
        if (!is_array($array)) {
            throw new Exception('Unable to set the config. You must provide an settings array!');
        }
        $this->settings = $array;
        return $this;
    }
}
