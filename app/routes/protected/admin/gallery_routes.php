<?php
require_once 'app/controllers/admin/gallery/AdminGalleryController.php';
require_once 'app/controllers/gallery/GalleryController.php';

$r->addRoute('GET', '/gallery', [GalleryController::class, 'index']);
$r->addRoute('GET', '/admin/gallery', [AdminGalleryController::class, 'index']);
$r->addRoute('GET', '/admin/gallery/create', [AdminGalleryController::class, 'create']);
$r->addRoute('POST', '/admin/gallery/delete/{id}', [AdminGalleryController::class, 'destroy']);
$r->addRoute('POST', '/admin/gallery', [AdminGalleryController::class, 'store']);
