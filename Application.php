<?php
use MC\Core;
namespace MC\Core;
class Application {

    protected $realPath;

    function __construct($documentRoot) {
        $this->realPath = $documentRoot;
    }

    public function run() {
        $this->_includes();
        /**
         *  In der folgenden Zeile wird zuerst ein Config-Objekt erzeugt, um grundsätzliche Einstellungen
         *  machen zu können.
         */
        $config = new Config();
        /**
         * In der folgenden Zeile wird ein Paar Grundeinstellungen des Systems gemacht
         */
        $config->rootPath= $this->realPath;
        $config->appDir= $this->realPath . 'app' . DIRECTORY_SEPARATOR;
        $config->modulesDir= $config->appDir . 'modules' . DIRECTORY_SEPARATOR;
        $config->pluginsDir= $config->appDir . 'plugins' . DIRECTORY_SEPARATOR;
        $config->libsDir= $this->realPath . 'libs' . DIRECTORY_SEPARATOR;
        $config->webDir= $this->realPath . 'web' . DIRECTORY_SEPARATOR;
        $config->logDir= $this->realPath . 'var' . DIRECTORY_SEPARATOR;
        /**
         * In der folgenden Zeile wird ein Service-Container-Objekt nach Registry-Pattern erzeugt.
         */
        $services = new Registry($config);

        /**
         * In den folgenden Zeilen werden ein Auto-Loader-Objekt erzeugt und danach werden
         * Verzeichnisse zum Autoladen registriert. Anschliessend wird Autolade-Methode
         * aufgerufen.
         */
        $loader = new Loader();
        $loader->setDir('classes', $config->rootPath . 'classes' . DIRECTORY_SEPARATOR);
        $loader->setDir('plugins', $config->pluginsDir);
        $loader->setDir('libs', $config->libsDir);
        $loader->autoLoad();
        $services->loader = $loader;

        $dispatcher = new Dispatcher($services);
        $services->dispatcher = $dispatcher;

        SPS_Debug::setFile($config->logDir . 'logs.log');

        $logger = new \Phalcon\Logger\Adapter\File($this->realPath . 'var' . DIRECTORY_SEPARATOR . 'log.log');
        $services->logger = $logger;

        $flash = new \Phalcon\Flash\Direct();
        $services->flash = $flash;

//         SPS_Debug::debug($services->getAll());

        $dispatcher->dispatch();
    }

    /**
     * @return: Folgende private Funktion inkludiert drei wichtigsten Kompononte
     * in das System
     */
    private function _includes() {
        include_once ($this->realPath . 'classes' . DIRECTORY_SEPARATOR . 'SPS_Config.php');
        include_once ($this->realPath . 'classes' . DIRECTORY_SEPARATOR . 'SPS_ServiceContainer.php');
        include_once ($this->realPath . 'classes' . DIRECTORY_SEPARATOR . 'SPS_Loader.php');
    }

}