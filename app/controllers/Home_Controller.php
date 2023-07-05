<?php
require './app/models/Home_Model.php';

class HomeHandler
{
    private $homeModel;
    private $mailer;
    public function __construct()
    {
        $this->homeModel = new HomeModel();
        $this->mailer = new Mailer();

    }

    public function getUsers()
    {
        $renderer = new Renderer(); 

        echo $renderer->render("Layout.php",[
            "content" => $renderer->render("/pages/Content.php", [])
        ]);
    }

}
