<?php

use App\Core\Core as App;

$app = (new App(dirname(__DIR__)));

// Route for api
require_once 'routes/api/api_route.php';

// Route for web
require_once 'routes/web/web_route.php';
