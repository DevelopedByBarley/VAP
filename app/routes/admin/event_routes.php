<?php
require 'app/controllers/events/Event_Controller.php';
require 'app/controllers/events/Event_Render.php';
$r->addRoute('GET', '/admin/events', [EventRender::class, 'index']);
$r->addRoute('GET', '/admin/events/new', [EventRender::class, 'eventForm']);
$r->addRoute('GET', '/admin/events/update/{id}', [EventRender::class, 'updateEventForm']);
$r->addRoute('GET', '/admin/events/delete/{id}', [EventController::class, 'deleteEvent']);


$r->addRoute('POST', '/admin/events/new', [EventController::class, 'newEvent']);
$r->addRoute('POST', '/admin/events/update/{id}', [EventController::class, 'updateEvent']);



