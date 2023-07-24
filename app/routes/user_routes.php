<?php
require 'app/controllers/User_Controller.php';

$r->addRoute('GET', '/language', [UserController::class, 'setLanguage']);
$r->addRoute('GET', '/user/registration', [UserController::class, 'registerForm']);
$r->addRoute('GET', '/language/{lang}', [UserController::class, 'switchLanguage']);
$r->addRoute('GET', '/login', [UserController::class, 'loginForm']);
$r->addRoute('GET', '/user/dashboard', [UserController::class, 'dashboard']);
$r->addRoute('GET', '/user/logout', [UserController::class, 'logout']);
$r->addRoute('GET', '/user/password-reset', [UserController::class, 'resetPasswordForm']);
$r->addRoute('GET', '/user/documents', [UserController::class, 'userDocuments']);
$r->addRoute('GET', '/user/documents/new', [UserController::class, 'documentForm']);
$r->addRoute('GET', '/user/documents/delete/{id}', [UserController::class, 'deleteUserDocument']);
$r->addRoute('GET', '/user/documents/update/{id}', [UserController::class, 'updateUserDocumentForm']);



$r->addRoute('POST', '/language', [UserController::class, 'setLanguage']);
$r->addRoute('POST', '/user/register', [UserController::class, 'registration']);
$r->addRoute('POST', '/user/login', [UserController::class, 'login']);
$r->addRoute('POST', '/user/update', [UserController::class, 'updateUser']);
$r->addRoute('POST', '/user/password-reset', [UserController::class, 'resetPassword']);
$r->addRoute('POST', '/user/delete', [UserController::class, 'deleteUser']);
$r->addRoute('POST', '/user/documents/update/{id}', [UserController::class, 'updateUserDocument']);
$r->addRoute('POST', '/user/documents/new', [UserController::class, 'newDocument']);
