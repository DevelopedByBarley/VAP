<?php
require 'app/controllers/documents/Document_Controller.php';
require 'app/controllers/documents/Document_Render.php';
$r->addRoute('GET', '/admin/documents', [DocumentRender::class, 'index']);
$r->addRoute('GET', '/admin/documents/new', [DocumentRender::class, 'documentForm']);
$r->addRoute('GET', '/admin/documents/update/{id}', [DocumentRender::class, 'updateForm']);


$r->addRoute('GET', '/admin/documents/delete/{id}', [DocumentController::class, 'deleteDocument']);


$r->addRoute('POST', '/admin/document/new', [DocumentController::class, 'uploadDocument']);
$r->addRoute('POST', '/admin/document/update/{id}', [DocumentController::class, 'updateDocument']);


