<?php
require_once 'app/controllers/subscriptions/Subscriptions_Controller.php';
require_once 'app/controllers/subscriptions/Subscriptions_Render.php';


$r->addRoute('GET', '/event/registration/delete/{id}', [SubscriptionsController::class, 'deleteSubscription']);
