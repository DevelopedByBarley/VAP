<?php
require_once 'app/controllers/events/Event_Controller.php';
require_once 'app/controllers/events/Event_Render.php';

$r->addRoute('GET', '/events', [EventRender::class, 'events']);
$r->addRoute('GET', '/event/{slug}', [EventRender::class, 'event']);



