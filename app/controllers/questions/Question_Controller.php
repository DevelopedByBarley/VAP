<?php
require_once 'app/models/Question_Model.php';

class QuestionController
{
  protected $questionModel;
  protected $renderer;
  protected $adminModel;

  public function __construct()
  {
    $this->questionModel = new QuestionModel();
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
  }

  //PROTECTED

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
