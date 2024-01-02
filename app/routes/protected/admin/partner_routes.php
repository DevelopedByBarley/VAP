<?php
require_once 'app/controllers/partners/Partner_Controller.php';
require_once 'app/controllers/partners/Partner_Render.php';
$r->addRoute('GET', '/admin/partners', [PartnerRender::class, 'index']);
$r->addRoute('GET', '/admin/partners/new', [PartnerRender::class, 'partnerForm']);
$r->addRoute('GET', '/admin/partners/update/{id}', [PartnerRender::class, 'updatePartnerForm']);


$r->addRoute('GET', '/admin/partners/delete/{id}', [PartnerController::class, 'deletePartner']);


$r->addRoute('POST', '/admin/partners/new', [PartnerController::class, 'newPartner']);
$r->addRoute('POST', '/admin/partners/update/{id}', [PartnerController::class, 'updatePartner']);


