<?php
namespace MC\Core;
Class Registry {

    protected $registry = array();
/** create a registry object with $config object
 * * @param  \MC\Core\Config $config
 * @throws Exception or set the $config object as a service
 */
    function __construct($config) {
        if (!isset($config)) {
            throw new Exception('Please provide config object!');
        }
        $this->set('config', $config);
    }
/**
 * Set a service in Regitry
 * @param string $key
 * @param string $value
 * @return \MC\Core\Registry
 * @throws Exception or set a service and
 * @return $this
 */
    public function __set($key, $value) {
        if (isset($this->registry[$key])) {
            throw new Exception('Unable to set value `' . $key . '`. it is already set.');
        }
        $this->registry[$key] = $value;
        return $this;
    }
/**
 * Get a service from Registry
 * @param string $key
 * @return boolean or the service with id $key
 */
    public function __get($key) {
        if (!isset($this->registry[$key])) {
            return false;
        }
        return $this->registry[$key];
    }
/**
 * Get all Services from the Registry
 * @return registry array
 */
    public function getAll() {
        return $this->registry;
    }
/**
 * Remove service with $key
 * @param string $key
 * @return \MC\Core\Registry
 */
    public function remove($key) {
        unset($this->registry[$key]);
        return $this;
    }

}
