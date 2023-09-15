<?php
require 'app/controllers/user/User_Controller.php';
require 'app/controllers/user/User_Render.php';

$r->addRoute('GET', '/login', [UserRender::class, 'loginForm']);
$r->addRoute('GET', '/user/registration', [UserRender::class, 'registerForm']);
$r->addRoute('GET', '/user/dashboard', [UserRender::class, 'dashboard']);
$r->addRoute('GET', '/user/password-reset', [UserRender::class, 'resetPasswordForm']);
$r->addRoute('GET', '/user/documents/new', [UserRender::class, 'documentForm']);
$r->addRoute('GET', '/user/documents/update/{id}', [UserRender::class, 'updateUserDocumentForm']);
$r->addRoute('GET', '/user/documents', [UserRender::class, 'userDocuments']);
$r->addRoute('GET', '/user/forgot-pw', [UserRender::class, 'forgotPwForm']);
$r->addRoute('GET', '/user/reset-pw', [UserRender::class, 'resetPwForm']);



$r->addRoute('GET', '/language', [UserController::class, 'setLanguage']);
$r->addRoute('GET', '/language/{lang}', [UserController::class, 'switchLanguage']);
$r->addRoute('GET', '/user/logout', [UserController::class, 'logout']);
$r->addRoute('GET', '/user/documents/delete/{id}', [UserController::class, 'deleteUserDocument']);



$r->addRoute('POST', '/language', [UserController::class, 'setLanguage']);
$r->addRoute('POST', '/user/register', [UserController::class, 'registration']);
$r->addRoute('POST', '/user/login', [UserController::class, 'login']);
$r->addRoute('POST', '/user/update', [UserController::class, 'updateUser']);
$r->addRoute('POST', '/user/password-reset', [UserController::class, 'resetPassword']);
$r->addRoute('POST', '/user/delete', [UserController::class, 'deleteUser']);
$r->addRoute('POST', '/user/documents/update/{id}', [UserController::class, 'updateUserDocument']);
$r->addRoute('POST', '/user/documents/new', [UserController::class, 'newDocument']);
$r->addRoute('POST', '/user/pw/new', [UserController::class, 'newPwRequest']);
$r->addRoute('POST', '/user/set-new-pw', [UserController::class, 'setNewPw']);

