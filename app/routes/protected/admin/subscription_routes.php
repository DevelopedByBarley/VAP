<?php
  require_once 'app/controllers/subscriptions/Subscriptions_Render.php';
  require_once 'app/controllers/subscriptions/Subscriptions_Controller.php';

  $r->addRoute('GET', '/admin/event/subscriber/{id}', [SubscriptionsRender::class, 'subscriber']);
  $r->addRoute('GET', '/admin/event/subscriptions/{id}', [SubscriptionsRender::class, 'subscriptions']);
  $r->addRoute('GET', '/admin/subscription/delete/{id}', [SubscriptionsRender::class, 'declineSubscription']);
  $r->addRoute('GET', '/admin/event/subscriber/email/{id}', [SubscriptionsRender::class, 'subMailForm']);
  $r->addRoute('GET', '/admin/event/email/{id}', [SubscriptionsRender::class, 'mailForm']);
  $r->addRoute('GET', '/event/subscribe/{id}', [SubscriptionsRender::class, 'subscribeForm']);


  $r->addRoute('GET', '/admin/subscription/accept/{id}', [SubscriptionsController::class, 'acceptSubscription']);
  $r->addRoute('GET', '/admin/subscription/export-subscribers', [SubscriptionsController::class, 'exportSubs']);

  



  $r->addRoute('POST', '/admin/event/email/send/{id}', [SubscriptionsController::class, 'sendMailsToSubbeddUsers']);
  $r->addRoute('POST', '/admin/subscriber/email/send/{id}', [SubscriptionsController::class, 'sendMailToSub']);


?>