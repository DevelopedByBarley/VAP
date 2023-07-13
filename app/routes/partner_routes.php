<?php
require 'app/controllers/Partner_Controller.php';
$r->addRoute('GET', '/admin/partners', [PartnerController::class, 'index']);
$r->addRoute('GET', '/admin/partners/new', [PartnerController::class, 'partnerForm']);
$r->addRoute('POST', '/admin/partners/new', [PartnerController::class, 'newPartner']);


