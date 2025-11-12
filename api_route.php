<?php

/* Procesa llamados del tipo "api/recurso/:params", rutea según recurso y verbo.
https://gitlab.com/unicen/Web2/livecoding2025/tandil/todo-list-rest/-/tree/main/libs/router */

require_once 'libs/router/router.php';
require_once 'libs/jwt/jwt.php';
require_once 'libs/jwt/jwt.middleware.php';
require_once 'app/middlewares/guard-api.middleware.php';
require_once 'app/controllers/ApiSongController.php';
require_once 'app/controllers/ApiAuthController.php';

# Se instancia el Router
$router = new Router();

$router->addMiddleware(new JWTMiddleware());

# Se definen los endpoints con el método addRoute
#                  resource          httpMethod     controller                  methodController
$router->addRoute('auth/login',      'POST',        'ApiAuthController',        'login');
$router->addRoute('songs',           'GET',         'ApiSongController',        'getSongs');
$router->addRoute('songs/:id',       'GET',         'ApiSongController',        'getSong');

# Necesitan TOKEN
$router->addMiddleware(new GuardMiddleware());
$router->addRoute('songs',           'POST',        'ApiSongController',        'addSong');
$router->addRoute('songs/:id',       'PUT',         'ApiSongController',        'editSong');

# Se toman el recurso y el método solicitado para rutear
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
# El router pasa los objetos request y response al método del controlador