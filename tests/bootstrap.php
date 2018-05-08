<?php
require __DIR__ . '/../vendor/autoload.php';
date_default_timezone_set('UTC');

// подключаем фабрику для ApiClient подключающуюся к тестовому серверу
require 'TestEnvironmentManager.php';