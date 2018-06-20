<?php
require __DIR__ . '/../vendor/autoload.php';
date_default_timezone_set('UTC');

// фабрика для ApiClient с параметрами подключения к тестовому серверу
require 'TestEnvironmentManager.php';
// генератор демоданых для тестов
require 'DemoDataGenerator.php';