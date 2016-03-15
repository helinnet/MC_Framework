<?php

error_reporting(E_ALL);
/**
 * here we define the document root of the application
 */
$documentRoot = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR;
/**
 * @filesource We are including the Application Class from classes directory
 */
include_once ( $documentRoot . 'classes' . DIRECTORY_SEPARATOR . 'SPS_Application.php');
/**
 * In der folgenden Zeilen wird die Applikation in einem Try-Catch-Block ausgeführt.
 */
try {
    /**
     * @return SPS_Application this class includes neccesary files and runs the application
     */
    $app = new SPS_Application($documentRoot);
    $app->run();
} catch (Exception $e ) {
    echo "<pre>";
    echo "Exception: " . $e->getFile();
    echo " on Line : ";
    echo $e->getLine();
    echo "<hr>";
    echo $e->getMessage();
    echo "<hr>";
}