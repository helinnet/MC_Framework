<?php
include_once ($realPath . 'classes' . DIRECTORY_SEPARATOR . 'SPS_Config.php');
include_once ($realPath . 'classes' . DIRECTORY_SEPARATOR . 'SPS_ServiceContainer.php');
include_once ($realPath . 'classes' . DIRECTORY_SEPARATOR . 'SPS_Loader.php');
//Config-Objekt erzeugen
$config = new SPS_Config();
//Manche Einstellungen machen
$config->set('rootPath', $realPath);
$config->set('appDir', $realPath . 'app'. DS);
$config->set('modulesDir', $config->get('appDir') . 'modules' . DS);
$config->set('pluginsDir', $config->get('appDir') . 'plugins' . DS);
$config->set('libsDir', $realPath . 'libs' . DS);
$config->set('webDir', $realPath . 'web' . DS);

//ServiceContainer-Objekt erzeugen
$services = new SPS_ServiceContainer($config);

//Loader-Objekt erzeugen
$loader = new SPS_Loader($services);
$loader->setDir('classes', $config->rootPath . 'classes' . DS);
$loader->setDir('plugins', $config->pluginsDir);
$loader->setDir('libs', $config->libsDir);
$loader->load();
$translater = new SPS_Translate($services);