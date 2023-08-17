<?php
require 'app/models/Question_Model.php';

class QuestionController extends AdminController
{
  protected $questionModel;

  public function __construct()
  {
    parent::__construct();
    $this->questionModel = new QuestionModel();
  }

  public function newQuestion()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->questionModel->new($_POST);
  }

  public function deleteQuestion($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->questionModel->delete($vars["id"]);
  }

  public function updateQuestion($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->questionModel->update($vars["id"], $_POST);
  }
}
