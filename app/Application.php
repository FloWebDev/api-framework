<?php

// https://www.php.net/manual/fr/function.session-set-cookie-params.php
session_set_cookie_params(CFG_SESSION_LIFETIME, "/");
session_start();

use App\Controller\SecurityController;
use App\Controller\ErrorController as Error;
use App\Controller\ApiController\ApiController;
use App\Controller\BackController\AdminController;
use App\Controller\BackController\EntityController;
use App\Controller\FrontController\DefaultController;

$router = new AltoRouter();

// Définition des routes
$router->map( 'GET', '/', function() {
    $controller = new DefaultController();
    $controller->homePage();
}, 'home_page');

$router->map( 'GET|POST', '/login', function() {
    $controller = new SecurityController();
    $controller->signIn();
}, 'sign_in');

$router->map( 'GET|POST', '/logout', function() {
    $controller = new SecurityController();
    $controller->logout();
}, 'logout');

$router->map( 'GET', '/dashboard', function() {
    $controller = new EntityController();
    $controller->entityList();
}, 'dashboard');

$router->map( 'GET|POST', '/inscription', function() {
    $controller = new SecurityController();
    $controller->signUp();
}, 'sign_up');

$router->map( 'GET|POST', '/users', function() {
    $controller = new AdminController();
    $controller->userList();
}, 'users');

$router->map( 'GET', '/delete/user/[i:id]', function($id) {
    $controller = new AdminController();
    $controller->userDelete($id);
}, 'delete_user');

$router->map( 'POST', '/update/user', function() {
    $controller = new AdminController();
    $controller->userUpdate();
}, 'update_user');

$router->map( 'GET|POST', '/token', function() {
    $controller = new DefaultController();
    $controller->token();
}, 'token');

$router->map( 'GET|POST', '/new/entity', function() {
    $controller = new EntityController();
    $controller->entityNew();
}, 'new_entity');

$router->map( 'GET|POST', '/update/entity/[i:id]', function($id) {
    $controller = new EntityController();
    $controller->entityUpdate($id);
}, 'update_entity');

$router->map( 'GET', '/delete/entity/[i:id]', function($id) {
    $controller = new EntityController();
    $controller->entityDelete($id);
}, 'delete_entity');

$router->map( 'GET', '/purge', function() {
    $controller = new EntityController();
    $controller->purge();
}, 'purge_entity');

$router->map( 'GET', '/alim-curl', function() {
    $controller = new DefaultController();
    $controller->alimCurl();
}, 'alim-curl');

$router->map( 'GET|POST', '/jwt', function() {
    $controller = new DefaultController();
    $controller->jwt();
}, 'jwt');

$router->map( 'GET', '/scrapping', function() {
    $controller = new DefaultController();
    $controller->scrapping();
}, 'scrapping');

// Définition des routes de l'API

$router->map( 'GET', '/api/get', function() {
    $controller = new ApiController();
    $controller->apiGet();
}, 'api_get');

$router->map( 'GET', '/api/find', function() {
    $controller = new ApiController();
    $controller->apiFind();
}, 'api_find');

$router->map( 'GET', '/api/random', function() {
    $controller = new ApiController();
    $controller->apiRandom();
}, 'api_random');

$router->map( 'GET', '/api/get/random', function() {
    $controller = new ApiController();
    $controller->apiGetRandom();
}, 'api_get_random');

$router->map( 'POST', '/api/token', function() {
    $controller = new ApiController();
    $controller->apiToken();
}, 'api_token');

// match current request url
$match = $router->match();

// dd($router->getRoutes());

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
    $error = new Error();
    $error->error404Html();
	// Error::error404();
}