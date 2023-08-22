<?php

$r->addRoute('GET', '/event/register/{id}', [EventRender::class, 'registerToEventForm']);
$r->addRoute('POST', '/event/register/{id}', [EventController::class, 'registerUserToEvent']);