<?php
namespace MC\Core;
class Translate {

    protected $messages = array();
    protected $services;
    protected $language;

    function __construct($services) {
        if (!isset($services)) {
            throw new Exception('Please provide a service container object!');
        }
        $this->services = $services;
        $this->messages = $this->loadLanguageFile();
    }

    public function loadLanguageFile($lang = '') {
        if (empty($lang)) {
            $messages = include __DIR__ . DIRECTORY_SEPARATOR . 'messages' . DIRECTORY_SEPARATOR . 'en' . DIRECTORY_SEPARATOR . 'classes.php';
        } else {
            $messages = include __DIR__ . DIRECTORY_SEPARATOR . 'messages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . 'classes.php';
        }

        return $messages;
    }

    public function t($m, $vars = array()) {// array('%actionName%' => $this->actionName, '%controllerFile%' => $controllerFile
        $message = $this->messages[$m]; // %actionName% in %controllerFile% is not found!
        if (!empty($vars)) {
            foreach ($vars as $place_holder => $value) {
                $message = str_replace($place_holder, $value, $message);
            }
        }
        return $message;
    }

}
