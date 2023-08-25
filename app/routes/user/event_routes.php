<?php

$r->addRoute('GET', '/event/register/{id}', [EventRender::class, 'registerToEventForm']);
$r->addRoute('GET', '/event/success', [EventRender::class, 'success']);


$r->addRoute('POST', '/event/register/{id}', [EventController::class, 'registerUserToEvent']);
