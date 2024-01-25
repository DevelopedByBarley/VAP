<?php
  require_once 'app/controllers/registrations/Subscriptions_Render.php';
  require_once 'app/controllers/registrations/Subscriptions_Controller.php';


  $r->addRoute('GET', '/admin/registrations', [SubscriptionsRender::class, 'registrations']);
  $r->addRoute('GET', '/admin/user/{id}', [SubscriptionsRender::class, 'profile']);
  $r->addRoute('GET', '/admin/user/mail/{id}', [SubscriptionsRender::class, 'userMailPage']);

  
  $r->addRoute('GET', '/admin/ban-user/{id}', [SubscriptionsController::class, 'banUser']);


  $r->addRoute('POST', '/admin/user/email/send/{id}', [SubscriptionsController::class, 'sendMailToUser']);

?>