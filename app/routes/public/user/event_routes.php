<?php
require_once 'app/controllers/events/Event_Controller.php';
require_once 'app/controllers/events/Event_Render.php';

$r->addRoute('GET', '/event/{id}', [EventRender::class, 'event']);
$r->addRoute('GET', '/event/subscribe/{id}', [EventRender::class, 'subscribeForm']);

$r->addRoute('GET', '/subscription/delete/{id}', [EventController::class, 'deleteRegistrationFromMail']);

$r->addRoute('POST', '/event/subscribe/{id}', [EventController::class, 'registerUserToEvent']);

