<?php

class HomeController
{

    public function getUsers()
    {
        $renderer = new Renderer(); 
        session_start();
        echo $renderer->render("Layout.php",[
            "content" => $renderer->render("/pages/Content.php", [])
        ]);
    }

}
