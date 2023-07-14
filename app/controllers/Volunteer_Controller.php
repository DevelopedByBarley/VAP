<?php
require 'app/models/Volunteer_Model.php';

class VolunteerController extends AdminController
{
  private $volunteerModel;

  public function __construct()
  {
    parent::__construct();
    $this->volunteerModel = new VolunteerModel();
  }

  public function newVolunteer()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $this->volunteerModel->addVolunteer($_FILES, $_POST);
  }

  public function updateVolunteer($vars)
  {
    $this->volunteerModel->update($_FILES, $vars["id"], $_POST);
  }

  public function deleteVolunteer($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $this->volunteerModel->deleteVolunteer($vars["id"]);
  }

  public function volunteersPage()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $volunteers = $this->volunteerModel->getVolunteers();

    $admin = $this->adminModel->admin();

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/volunteers/Volunteers.php", [
        "volunteers" => $volunteers ?? null,
        "descriptionInLang" => $descriptionInLang ?? null
      ]),
      "admin" => $admin
    ]);
  }
  public function volunteersForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/volunteers/Form.php", [])
    ]);
  }

  public function updateVolunteerForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $admin = $this->adminModel->admin();
    $volunteer = $this->volunteerModel->getVolunteerByCommonId($vars["id"]);



    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/volunteers/UpdateForm.php", [
        "admin" => $admin ?? null,
        "volunteer" => $volunteer ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
