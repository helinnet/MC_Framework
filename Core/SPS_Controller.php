<?php
abstract class SPS_Controller {
        protected $services;
        function __construct($services) {
                $this->services = $services;
        }
        abstract function index();
}