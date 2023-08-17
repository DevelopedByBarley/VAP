<?php
require 'app/controllers/questions/Question_Controller.php';
require 'app/controllers/questions/Question_Render.php';


$r->addRoute('GET', '/admin/questions', [QuestionRender::class, 'index']);
$r->addRoute('GET', '/admin/questions/new', [QuestionRender::class, 'questionsForm']);
$r->addRoute('GET', '/admin/questions/update/{id}', [QuestionRender::class, 'questionsUpdateForm']);


$r->addRoute('GET', '/admin/questions/delete/{id}', [QuestionController::class, 'deleteQuestion']);



$r->addRoute('POST', '/admin/questions/new', [QuestionController::class, 'newQuestion']);
$r->addRoute('POST', '/admin/questions/update/{id}', [QuestionController::class, 'updateQuestion']);
