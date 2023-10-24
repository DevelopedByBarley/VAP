<?php
require_once 'app/controllers/events/Event_Controller.php';
require_once 'app/controllers/events/Event_Render.php';


$r->addRoute('GET', '/admin/events', [EventRender::class, 'index']);
$r->addRoute('GET', '/admin/events/new', [EventRender::class, 'eventForm']);
$r->addRoute('GET', '/admin/events/update/{id}', [EventRender::class, 'updateEventForm']);
$r->addRoute('GET', '/admin/event/{id}', [EventRender::class, 'adminEvent']);
$r->addRoute('GET', '/admin/event/user/{id}', [EventRender::class, 'registeredUser']);
$r->addRoute('GET', '/admin/event/subscriptions/{id}', [EventRender::class, 'subscriptions']);
$r->addRoute('GET', '/admin/event/email/{id}', [EventRender::class, 'mailForm']);



$r->addRoute('GET', '/admin/events/delete/{id}', [EventController::class, 'deleteEvent']);
$r->addRoute('GET', '/admin/event/state/{id}', [EventController::class, 'setEventState']);
$r->addRoute('GET', '/admin/subscription/accept/{id}', [EventController::class, 'acceptSubscription']);
$r->addRoute('GET', '/admin/subscription/delete/{id}', [EventController::class, 'deleteSubscription']);





$r->addRoute('POST', '/admin/events/new', [EventController::class, 'newEvent']);
$r->addRoute('POST', '/admin/events/update/{id}', [EventController::class, 'updateEvent']);
$r->addRoute('POST', '/admin/event/email/send/{id}', [EventController::class, 'sendMailsToRegisteredUsers']);



