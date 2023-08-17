<?php
require  'app/controllers/volunteers/Volunteer_Controller.php';
require  'app/controllers/volunteers/Volunteer_Render.php';

$r->addRoute('GET', '/admin/volunteers', [VolunteerRender::class, 'volunteersPage']);
$r->addRoute('GET', '/admin/volunteers/new', [VolunteerRender::class, 'volunteersForm']);
$r->addRoute('GET', '/admin/volunteers/update/{id}', [VolunteerRender::class, 'updateVolunteerForm']);


$r->addRoute('GET', '/admin/volunteers/delete/{id}', [VolunteerController::class, 'deleteVolunteer']);


$r->addRoute('POST', '/admin/volunteers/new', [VolunteerController::class, 'newVolunteer']);
$r->addRoute('POST', '/admin/volunteers/update/{id}', [VolunteerController::class, 'updateVolunteer']);