<?php

require_once "vendor/autoload.php";

$app = new Slim();

// Use Twig for templating
require 'vendor/slim/extras/Views/TwigView.php';
$app->view('TwigView');

require_once "urls.php";
require_once "controllers.php";

$app->run();
