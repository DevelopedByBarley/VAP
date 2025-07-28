<?php
require_once 'app/services/AuthService.php';
require_once 'app/helpers/LoginChecker.php';
require_once 'app/helpers/FileSaver.php';
require_once 'app/models/Gallery_Model.php';
require_once 'app/models/Event_Model.php';
require_once 'app/helpers/Renderer.php';

class GalleryController
{
  private $galleryModel;
  private $renderer;

  public function __construct()
  {
    $this->galleryModel = new GalleryModel();
    $this->renderer = new Renderer();
  }
  public function index()
  {
    session_start();
    $images = $this->galleryModel->getAllGalleryImages();
    $events = (new EventModel())->all();

    echo $this->renderer->render("Layout.php", [
      "title" => "Gallery",
      "content" => $this->renderer->render("/pages/public/Gallery.php", [
        "images" => $images,
        "events" => $events,
      ]),
    ]);
  }
}
