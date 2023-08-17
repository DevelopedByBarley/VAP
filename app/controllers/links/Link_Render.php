<?php

class LinkRender extends LinkController
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $linksData = $this->linkModel->links();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/links/Links.php", [
        "admin" => $admin ?? null,
        "links" => $linksData["links"] ?? null,
        "numOfPage" => $linksData["numOfPage"] ?? null,
        "limit" => $linksData["limit"] ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function linkForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/links/Form.php", [
        "admin" => $admin ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function updateForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $link = $this->linkModel->getLinkById($vars["id"]);
    
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/links/UpdateForm.php", [
        "admin" => $admin ?? null,
        "link" => $link ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
