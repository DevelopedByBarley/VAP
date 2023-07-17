<?php
require 'app/controllers/Document_Controller.php';
$r->addRoute('GET', '/admin/documents', [DocumentController::class, 'index']);
$r->addRoute('GET', '/admin/documents/new', [DocumentController::class, 'documentForm']);
$r->addRoute('GET', '/admin/documents/delete/{id}', [DocumentController::class, 'deleteDocument']);
$r->addRoute('GET', '/admin/documents/update/{id}', [DocumentController::class, 'updateForm']);


$r->addRoute('POST', '/admin/document/new', [DocumentController::class, 'uploadDocument']);
$r->addRoute('POST', '/admin/document/update/{id}', [DocumentController::class, 'updateDocument']);


