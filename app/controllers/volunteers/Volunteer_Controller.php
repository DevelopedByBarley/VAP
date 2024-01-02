<?php
require_once 'app/models/Volunteer_Model.php';

class VolunteerController
{
  protected $volunteerModel;
  protected $renderer;
  protected $adminModel;

  public function __construct()
  {
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
    $this->volunteerModel = new VolunteerModel();
  }

  // PROTECTED

  public function newVolunteer()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $this->volunteerModel->addVolunteer($_FILES, $_POST);
  }
  
  public function updateVolunteer($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $this->volunteerModel->update($_FILES, $vars["id"], $_POST);
  }

  public function deleteVolunteer($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    $this->volunteerModel->deleteVolunteer($vars["id"]);
  }
}
