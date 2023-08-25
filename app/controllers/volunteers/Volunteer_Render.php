<?php

class VolunteerRender extends VolunteerController
{

  public function __construct()
  {
    parent::__construct();
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
    $admin = $this->adminModel->admin();

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/volunteers/Form.php", []),
      "admin" => $admin
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
