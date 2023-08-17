<?php
require 'app/models/Volunteer_Model.php';

class VolunteerController extends AdminController
{
  protected $volunteerModel;

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
}
