<?php
  require_once 'app/controllers/registrations/Registrations_Render.php';
  require_once 'app/controllers/registrations/Registrations_Controller.php';


  $r->addRoute('GET', '/admin/registrations', [RegistrationsRender::class, 'registrations']);
  $r->addRoute('GET', '/admin/user/{id}', [RegistrationsRender::class, 'profile']);
  $r->addRoute('GET', '/admin/user/mail/{id}', [RegistrationsRender::class, 'userMailPage']);

  
  $r->addRoute('GET', '/admin/ban-user/{id}', [RegistrationsController::class, 'banUser']);


  $r->addRoute('POST', '/admin/user/email/send/{id}', [AdminController::class, 'sendMailToUser']);

?>