<?php
require 'app/controllers/Question_Controller.php';
$r->addRoute('GET', '/admin/questions', [QuestionController::class, 'index']);
$r->addRoute('GET', '/admin/questions/delete/{id}', [QuestionController::class, 'deleteQuestion']);
$r->addRoute('GET', '/admin/questions/new', [QuestionController::class, 'questionsForm']);
$r->addRoute('GET', '/admin/questions/update/{id}', [QuestionController::class, 'questionsUpdateForm']);



$r->addRoute('POST', '/admin/questions/new', [QuestionController::class, 'newQuestion']);
$r->addRoute('POST', '/admin/questions/update/{id}', [QuestionController::class, 'updateQuestion']);
