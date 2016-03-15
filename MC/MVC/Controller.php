<?php
namespace MC\MVC;
abstract class Controller {
        protected $services;
        function __construct($services) {
                $this->services = $services;
        }
        abstract function index();
}