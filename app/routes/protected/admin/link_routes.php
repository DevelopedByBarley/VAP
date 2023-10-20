<?php
require_once 'app/controllers/links/Link_Controller.php';
require_once 'app/controllers/links/Link_Render.php';



$r->addRoute('GET', '/admin/links', [LinkRender::class, 'index']);
$r->addRoute('GET', '/admin/links/new', [LinkRender::class, 'linkForm']);
$r->addRoute('GET', '/admin/links/update/{id}', [LinkRender::class, 'updateForm']);


$r->addRoute('GET', '/admin/links/delete/{id}', [LinkController::class, 'deleteLink']);


$r->addRoute('POST', '/admin/links/new', [LinkController::class, 'addLink']);
$r->addRoute('POST', '/admin/links/update/{id}', [LinkController::class, 'updateLink']);
