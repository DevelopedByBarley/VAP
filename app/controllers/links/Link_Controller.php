<?php
require 'app/models/Link_Model.php';

class LinkController
{
  protected $linkModel;
  protected $renderer;
  protected $adminModel;

  public function __construct()
  {
    $this->linkModel = new LinkModel();
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
  }

  public function updateLink($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->linkModel->update($vars["id"], $_POST);
  }

  public function addLink()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->linkModel->insert($_POST);
  }

  public function deleteLink($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->linkModel->delete($vars["id"]);
  }
}
