<?php

class HomeController
{

    public function getUsers()
    {
        $renderer = new Renderer(); 

        echo $renderer->render("Layout.php",[
            "content" => $renderer->render("/pages/Content.php", [])
        ]);
    }

}
