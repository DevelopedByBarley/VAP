<?php

$r->addRoute('GET', '/event/register/{id}', [EventRender::class, 'registerToEventForm']);
$r->addRoute('GET', '/event/success', [EventRender::class, 'success']);
$r->addRoute('GET', '/event/{id}', [EventRender::class, 'event']);
$r->addRoute('GET', '/event/registration/delete/{id}', [EventController::class, 'deleteRegistration']);
$r->addRoute('GET', '/subscription/delete/{id}', [EventController::class, 'deleteRegistrationFromMail']);


$r->addRoute('POST', '/event/register/{id}', [EventController::class, 'registerUserToEvent']);