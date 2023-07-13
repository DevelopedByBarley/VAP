<?php
class HomeController
{

    private $userModel;
    private $volunteerModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->volunteerModel = new VolunteerModel();
    }

    public function home()
    {
        $renderer = new Renderer();
        session_start();
        $user = $this->userModel->getMe();
        $volunteers = $this->volunteerModel->getVolunteers();

        echo $renderer->render("Layout.php", [
            "content" => $renderer->render("/pages/Content.php", [
                "volunteers" => $volunteers ?? null
            ]),
            "user" => $user ?? null,
        ]);
    }
}
