<?php 

require './Router.php';

$router = new Router();

$router -> get('/test', function() {
    return 'GET OK';
});

$router -> post('/test', function() {
    return 'POST OK';
});

$router->put('/test', function () {
    return "PUT OK";
});

$router -> patch('/test', function() { 
    return 'PATCH OK';
});

$router->delete('/test', function () {
    return "DELETE OK";
});

try { 
    $action = $router ->resolve(); 
    print($action());
} catch (HttpNotFoundException $e) { 
    print('Not Found'); 
    http_response_code(404);
}

?>