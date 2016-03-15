<?php
namespace MC\Core;
Class Dispatcher {
/**
 *Services from Registry
 * @var \MC\Core\Registry
 */
    protected $services;
    /**
     * Request query
     * @var string
     */
    protected $request;

    public $controllerName;
    public $actionName;
    public $parameters = array();

    function __construct($services) {
        if (!isset($services)) {
            throw new Exception('Please provide a service container object!');
        }
        $this->services = $services;
        $this->request = (isset($_REQUEST['_request']) && !empty($_REQUEST['_request'])) ? $_REQUEST['_request'] : '';
    }

    public function dispatch() {
        $this->_analyseRequest();
        SPS_Debug::log('Request wurde analysiert');
        $this->services->logger->log('Request wurde analysiert');
        $controllerPath = $this->services->config->modulesDir . $this->moduleName . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->controllerName ;
        SPS_Debug::log('Controller Path :' . $controllerPath);
        $this->services->logger->log('Controller Path :' . $controllerPath);
        $controllerFile = $controllerPath . '.php';
        if(!is_dir($this->services->config->modulesDir . $this->moduleName )) {
             SPS_Debug::log('if not is_dir : ' . $this->services->config->modulesDir . $this->moduleName);
               $this->services->logger->log('if not is_dir : ' . $this->services->config->modulesDir . $this->moduleName);
//               $this->services->flash->error('if not is_dir : ' . $this->services->config->modulesDir . $this->moduleName);
            throw new Exception( $this->services->translater->t('Module_is_not_Found',  array('%module%' => $this->services->config->modulesDir . $this->moduleName)) );
        }
        if(!is_file($controllerFile)) {
                  SPS_Debug::log('In '. __FILE__ . ' on ' .  __LINE__ . ' if  not is_file : ' . $controllerFile);
                 $this->services->logger->log('In '. __FILE__ . ' on ' .  __LINE__ . ' if  not is_file : ' . $controllerFile);
//               $this->services->flash->error(' if  not is_file : ' . $controllerFile);
                 throw new Exception( $this->services->translater->t('Controller_is_not_Found', array('%controllerFile%' => $controllerFile) ));
        }

        include ($controllerFile);
          $this->services->logger->log(' include : ' . $controllerFile);

        $controller = new $this->controllerName($this->services);
        $this->services->logger->log(' new controller : ' .$this->controllerName);
        $view = new SPS_View($this->services);
        $this->services->logger->log(' new View : ');

        // ist die Methode vorhanden
        if ( !is_callable(array($controller, $this->actionName)) ) {
             SPS_Debug::log(' if not is_callable : ' . $this->actionName);
            $this->services->logger->log(' if not is_callable : ' . $this->actionName);
            throw new Exception( $this->services->translater->t('Action_is_not_Found', array('%actionName%' => $this->actionName, '%controllerFile%' => $controllerFile) ) );
        }
        // Aktion ausführen
        $action = $this->actionName;
        $themesFile = $this->services->config->appDir  . 'themes' . DIRECTORY_SEPARATOR . 'index.php';
        $this->services->logger->log(' themesFile : ' .$themesFile);
        $layoutFile = $this->services->config->modulesDir . $this->moduleName . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'index.php';
        $this->services->logger->log(' $layoutFile : ' .$layoutFile);
        $viewFile = $this->services->config->modulesDir . $this->moduleName . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->controllerName . DIRECTORY_SEPARATOR . $this->actionName . '.php' ;
          $this->services->logger->log(' $viewFile : ' .$viewFile);
        $view->setThemesFile($themesFile);
         $this->services->logger->log(' $view->setThemesFile($themesFile) : ');
        $view->setLayoutFile($layoutFile);
        $this->services->logger->log('    $view->setLayoutFile($layoutFile);  ');
        $view->setViewFile($viewFile);
          $this->services->logger->log('   $view->setViewFile($viewFile);  ');
        $controller->$action();
         $this->services->logger->log('  Controller acton wurde ausgeführt:  $controller->$action();  ');
    }

    private function _analyseRequest() {

        if (empty($this->request)) {
              $this->services->logger->log(__FILE__ . '      if (empty($this->request))           ');
            $this->moduleName = ($this->services->config->get('defaultModuleName') !== NULL ) ? $this->services->config->get('defaultModuleName') : 'index';
             $this->services->logger->log(__FILE__ . '  $this->moduleName  ' . $this->moduleName);
            $this->controllerName = ($this->services->config->get('defaultControllerName') !== NULL ) ? $this->services->config->get('defaultControllerName') : 'index';
               $this->services->logger->log(__FILE__  . '     $this->controllerName    ' . $this->controllerName );
            $this->actionName = ($this->services->config->get('defaultActionName') !== NULL ) ? $this->services->config->get('defaultActionName') : 'index';
            $this->services->logger->log(__FILE__ . '     $this->actionName   ' .$this->actionName );
        } else {
            //letzte Slash löschen
            $request = trim($this->request, '/\\');
              SPS_Debug::log(__FILE__ . ' on '. __LINE__ .  '    $request = trim  ' . $this->request );
             $this->services->logger->log(__FILE__ . '    $request = trim  ' . $this->request );
            // Anfrage unterteilen _request=module1/controller1/action1/param1/param2/param3/.../paramN/
            $requestPartsArray = explode('/', $request);

            if (count($requestPartsArray) == 1) {
                $this->moduleName = $requestPartsArray[0];
                $this->controllerName = ($this->services->config->get('defaultControllerName') !== NULL ) ? $this->services->config->get('defaultControllerName') : 'index';
                $this->actionName = ($this->services->config->get('defaultActionName') !== NULL ) ? $this->services->config->get('defaultActionName') : 'index';

            }
            if (count($requestPartsArray) == 2) {
                $this->moduleName = $requestPartsArray[0];
                $this->controllerName = $requestPartsArray[1];
                $this->actionName = ($this->services->config->get('defaultActionName') !== NULL ) ? $this->services->config->get('defaultActionName') : 'index';
            }
            if (count($requestPartsArray) == 3) {
                 $this->moduleName = $requestPartsArray[0];
                $this->controllerName = $requestPartsArray[1];
                $this->actionName = $requestPartsArray[2];
            }
             if (count($requestPartsArray) > 3) {
                 $this->moduleName = $requestPartsArray[0];
                $this->controllerName = $requestPartsArray[1];
                $this->actionName = $requestPartsArray[2];
                $this->parameters = array_slice($requestPartsArray, 3);

            }

        }
        return $this;
    }




}