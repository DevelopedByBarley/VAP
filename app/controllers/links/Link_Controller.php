<?php
require 'app/models/Link_Model.php';

class LinkController extends AdminController
{
  protected $linkModel;

  public function __construct()
  {
    parent::__construct();
    $this->linkModel = new LinkModel();
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
