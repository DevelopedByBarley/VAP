<?php
require  'app/controllers/Volunteer_Controller.php';

$r->addRoute('GET', '/admin/volunteers', [VolunteerController::class, 'volunteersPage']);
$r->addRoute('GET', '/admin/volunteers/new', [VolunteerController::class, 'volunteersForm']);
$r->addRoute('GET', '/admin/volunteers/delete/{id}', [VolunteerController::class, 'deleteVolunteer']);
$r->addRoute('GET', '/admin/volunteers/update/{id}', [VolunteerController::class, 'updateVolunteerForm']);


$r->addRoute('POST', '/admin/volunteers/new', [VolunteerController::class, 'newVolunteer']);
$r->addRoute('POST', '/admin/volunteers/update/{id}', [VolunteerController::class, 'updateVolunteer']);