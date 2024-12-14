<?php
session_start();

// Load core libraries
require 'libraries/Core.php';  // Core class that handles routing
require 'libraries/Controller.php';  // Base Controller class
require 'vendor/autoload.php';
require  'functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize Core to route the request
$core = new Core();
