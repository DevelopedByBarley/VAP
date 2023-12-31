<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
        
    
    require_once 'app/routes/protected/user/event_routes.php';
    require_once 'app/routes/protected/admin/admin_routes.php';
    require_once 'app/routes/protected/admin/volunteer_routes.php';
    require_once 'app/routes/protected/admin/partner_routes.php';
    require_once 'app/routes/protected/admin/question_routes.php';
    require_once 'app/routes/protected/admin/document_routes.php';
    require_once 'app/routes/protected/admin/link_routes.php';
    require_once 'app/routes/protected/admin/event_routes.php';
    require_once 'app/routes/protected/admin/registration_routes.php';


    require_once 'app/routes/protected/user/user_routes.php';
    require_once 'app/routes/protected/user/event_routes.php';
    
    
    
    require_once 'app/routes/public/home/home_routes.php';
    require_once 'app/routes/public/user/event_routes.php';
    require_once 'app/routes/public/user/user_routes.php';
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        require 'app/views/pages/error/404.php';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $handlerInstance = new $handler[0]();
        $handlerInstance->{$handler[1]}($vars);
        break;
}
