<?php
require 'app/controllers/Event_Controller.php';
$r->addRoute('GET', '/admin/events', [EventController::class, 'index']);
$r->addRoute('GET', '/admin/events/new', [EventController::class, 'eventForm']);
$r->addRoute('GET', '/admin/events/delete/{id}', [EventController::class, 'deleteEvent']);
$r->addRoute('GET', '/admin/events/update/{id}', [EventController::class, 'updateEventForm']);
$r->addRoute('GET', '/events/new/{id}', [EventController::class, 'userEventForm']);


$r->addRoute('POST', '/admin/events/new', [EventController::class, 'newEvent']);
$r->addRoute('POST', '/admin/events/update/{id}', [EventController::class, 'updateEvent']);



