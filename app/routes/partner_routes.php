<?php
require 'app/controllers/Partner_Controller.php';
$r->addRoute('GET', '/admin/partners', [PartnerController::class, 'index']);
$r->addRoute('GET', '/admin/partners/new', [PartnerController::class, 'partnerForm']);
$r->addRoute('GET', '/admin/partners/delete/{id}', [PartnerController::class, 'deletePartner']);
$r->addRoute('GET', '/admin/partners/update/{id}', [PartnerController::class, 'updatePartnerForm']);


$r->addRoute('POST', '/admin/partners/new', [PartnerController::class, 'newPartner']);
$r->addRoute('POST', '/admin/partners/update/{id}', [PartnerController::class, 'updatePartner']);


