<?php
require_once 'app/controllers/events/Event_Controller.php';
require_once 'app/controllers/events/Event_Render.php';


$r->addRoute('GET', '/event/registration/delete/{id}', [EventController::class, 'deleteRegistration']);
