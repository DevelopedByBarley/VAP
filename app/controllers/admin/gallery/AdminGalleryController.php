<?php
require_once 'app/services/AuthService.php';
require_once 'app/helpers/LoginChecker.php';
require_once 'app/helpers/FileSaver.php';
require_once 'app/models/Gallery_Model.php';
require_once 'app/models/Event_Model.php';


class AdminGalleryController extends AdminController
{
    protected $renderer;
    protected $authService;
    protected $adminModel;
    protected $galleryModel;
    protected $eventModel;



    public function __construct()
    {
        $this->renderer = new Renderer();
        $this->adminModel = new AdminModel();
        $this->authService = new AuthService();
        $this->galleryModel = new GalleryModel();
        $this->eventModel = new EventModel();
    }

    public function index() {
        LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
        $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION
        
        // GET offset from URL parameter
        $offset = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;
        
        $galleryData = $this->galleryModel->getGallery($offset); // GET PAGINATED GALLERY IMAGES
        $events = $this->eventModel->all(); // GET ALL EVENTS

        echo $this->renderer->render("Layout.php", [
            "content" => $this->renderer->render("pages/admin/gallery/index.php", [
                "galleryData" => $galleryData,
                "admin" => $admin ?? null,
                "events" => $events ?? null
            ]),
            "admin" => $admin ?? null
        ]);
    }

    public function create() {
        LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
        $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION
        $events = $this->eventModel->all(); // GET ALL EVENTS

        echo $this->renderer->render("Layout.php", [
            "content" => $this->renderer->render("pages/admin/gallery/create.php", [
                "admin" => $admin ?? null,
                "events" => $events ?? null
            ]),
            "admin" => $admin ?? null
        ]);
    }

    public function store() {
        LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
        $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION

        // Validate and save the image
        if (isset($_FILES['fileName']) && $_FILES['fileName']['error'] === UPLOAD_ERR_OK) {
            $fileSaver = new FileSaver();
            $imagePath = $fileSaver->saver($_FILES['fileName'], "images/gallery", null, [
                'image/png',
                'image/jpeg',
                'image/gif'
            ]);

            if ($imagePath) {
                $description = $_POST['description'] ?? '';
                $is_public = isset($_POST['is_public']) ? 1 : 0; // Check if the image should be public
                $event_id = isset($_POST['event_id']) && !empty($_POST['event_id']) ? (int)$_POST['event_id'] : null;
                $this->galleryModel->addImage($imagePath, $description, $is_public, $event_id);
                header("Location: /admin/gallery");
            } else {
                // Handle file save error
                echo "Hiba a kép mentésekor.";
            }
        } else {
            // Handle file upload error
            echo "Hiba a fájl feltöltésekor.";
        }
    }

    public function destroy($vars) {
        LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
        $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION

        // DELETE IMAGE FROM GALLERY
        $imageId = $vars["id"];
        $galleryImage = $this->galleryModel->getGalleryImageById($imageId);
        
        if ($galleryImage) {
            $this->galleryModel->deleteImage($imageId);
            unlink("./public/assets/images/gallery/" . $galleryImage['fileName']);
        }

        header("Location: /admin/gallery");
    }
}
