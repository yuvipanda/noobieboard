<?php

require_once "vendor/autoload.php";

$app = new Slim(array(
));

require_once "urls.php";
require_once "controllers.php";

$app->run();
