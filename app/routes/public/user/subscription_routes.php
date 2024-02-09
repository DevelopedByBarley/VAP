<?php

require_once 'app/controllers/subscriptions/Subscriptions_Render.php';
require_once 'app/controllers/subscriptions/Subscriptions_Controller.php';

$r->addRoute('GET', '/subscription/delete/{id}', [SubscriptionsController::class, 'deleteSubscriptionFromMail']);


$r->addRoute('POST', '/event/subscribe/{id}', [SubscriptionsController::class, 'subscribeUserToEvent']);
