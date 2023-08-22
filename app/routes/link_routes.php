<?php
require 'app/controllers/Link_Controller.php';



$r->addRoute('GET', '/admin/links', [LinkController::class, 'index']);
$r->addRoute('GET', '/admin/links/new', [LinkController::class, 'linkForm']);
$r->addRoute('GET', '/admin/links/delete/{id}', [LinkController::class, 'deleteLink']);
$r->addRoute('GET', '/admin/links/update/{id}', [LinkController::class, 'updateForm']);


$r->addRoute('POST', '/admin/links/new', [LinkController::class, 'addLink']);
$r->addRoute('POST', '/admin/links/update/{id}', [LinkController::class, 'updateLink']);
