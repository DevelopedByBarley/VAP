<?php
class HomeController
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function home()
    {
        $renderer = new Renderer(); 
        session_start();
        $user = $this->userModel->getMe();
        echo $renderer->render("Layout.php",[
            "content" => $renderer->render("/pages/Content.php", []),
            "user" => $user ?? null
        ]);
    }

}
