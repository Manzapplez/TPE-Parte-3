<?php

/* Procesa llamados del tipo "api/recurso/:params", rutea según recurso y verbo.
https://gitlab.com/unicen/Web2/livecoding2025/tandil/todo-list-rest/-/tree/main/libs/router */

require_once 'libs/router.php';
require_once 'app/controllers/ApiSongController.php';

# Se instancia el Router
$router = new Router();

# Se definen las rutas con el método addRoute
#                  resource          httpMethod     controller                  methodController
$router->addRoute('songs',           'GET',         'ApiSongController',        'getSongs');
$router->addRoute('songs/:id',       'GET',         'ApiSongController',        'getSong');
$router->addRoute('songs',           'POST',        'ApiSongController',        'addSong');
$router->addRoute('songs/:id',       'PUT',         'ApiSongController',        'editSong');

# Se toman el recurso y el método solicitado para rutear
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
# El router pasa los objetos request y response al método del controlador