<?php
require 'app/models/Question_Model.php';

class QuestionController extends AdminController
{
  private $questionModel;

  public function __construct()
  {
    parent::__construct();
    $this->questionModel = new QuestionModel();
  }

  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $questions = $this->questionModel->questions();

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/questions/Questions.php", [
        "admin" => $admin ?? null,
        "questions" =>  $questions ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function questionsForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/questions/Form.php", [
        "admin" => $admin ?? null,
        "questions" =>  $questions ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function questionsUpdateForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $question = $this->questionModel->question($vars["id"]);
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/questions/UpdateForm.php", [
        "admin" => $admin ?? null,
        "question" =>  $question ?? null
      ]),
      "admin" => $admin ?? null
    ]);
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
