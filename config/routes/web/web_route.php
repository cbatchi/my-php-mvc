<?php

use App\Controller\AuthController as Auth;
use App\Controller\HomeController as Home;

$app->router->get('/', [Home::class, 'homepage']);

$app->router->get('/register', [Auth::class, 'register']);
$app->router->post('/register', [Auth::class, 'register']);

$app->router->get('/login', [Auth::class, 'login']);
$app->router->post('/login', [Auth::class, 'login']);

$app->router->get('/contact', [Auth::class, 'contactUs']);
$app->router->post('/contact', [Auth::class, 'contactUs']);