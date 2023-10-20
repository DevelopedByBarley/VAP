<?php
require_once 'app/controllers/events/Event_Controller.php';
require_once 'app/controllers/events/Event_Render.php';

$r->addRoute('GET', '/event/register/{id}', [EventRender::class, 'registerToEventForm']);
$r->addRoute('GET', '/events', [EventRender::class, 'events']);
$r->addRoute('GET', '/event/{id}', [EventRender::class, 'event']);

$r->addRoute('GET', '/subscription/delete/{id}', [EventController::class, 'deleteRegistrationFromMail']);
$r->addRoute('POST', '/event/register/{id}', [EventController::class, 'registerUserToEvent']);

