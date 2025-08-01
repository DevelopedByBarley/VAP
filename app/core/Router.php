<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {


    require_once 'app/routes/protected/user/subscription_routes.php';
    require_once 'app/routes/protected/admin/admin_routes.php';
    require_once 'app/routes/protected/admin/volunteer_routes.php';
    require_once 'app/routes/protected/admin/partner_routes.php';
    require_once 'app/routes/protected/admin/question_routes.php';
    require_once 'app/routes/protected/admin/document_routes.php';
    require_once 'app/routes/protected/admin/link_routes.php';
    require_once 'app/routes/protected/admin/event_routes.php';
    require_once 'app/routes/protected/admin/subscription_routes.php';
    require_once 'app/routes/protected/admin/gallery_routes.php';


    require_once 'app/routes/protected/user/user_routes.php';
    require_once 'app/routes/protected/user/subscription_routes.php';



    require_once 'app/routes/public/home/home_routes.php';
    require_once 'app/routes/public/user/event_routes.php';
    require_once 'app/routes/public/user/user_routes.php';
    require_once 'app/routes/public/user/subscription_routes.php';
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
// Check if we have a rewritten URI from web.config
$uri = isset($_SERVER['HTTP_X_ORIGINAL_URI']) ? $_SERVER['HTTP_X_ORIGINAL_URI'] : $_SERVER['REQUEST_URI'];
$home_render = new HomeRender();


// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $ip = $_SERVER['REMOTE_ADDR'];

        if ((MAINTENANCE_PERMISSION === 1) && $ip != "84.0.122.186") {
            $home_render->maintenance();
            exit;
        }
        $home_render->errorPage();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $ip = $_SERVER['REMOTE_ADDR'];
        if ((MAINTENANCE_PERMISSION === 1) && $ip != "84.0.122.186") {
            $home_render->maintenance();
            exit;
        }

        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $handlerInstance = new $handler[0]();
        $handlerInstance->{$handler[1]}($vars);
        break;
}
