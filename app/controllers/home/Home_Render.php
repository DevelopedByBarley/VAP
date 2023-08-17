<?php
class HomeRender extends HomeController
{


    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        session_start();
        $user = $this->userModel->getMe();
        $volunteers = $this->volunteerModel->getVolunteers();
        $questions = $this->questionModel->questions();
        $partners = $this->partnerModel->partners();
        $documents = $this->documentModel->index();
        $links = $this->linkModel->index();



        echo $this->renderer->render("Layout.php", [
            "content" => $this->renderer->render("/pages/Content.php", [
                "volunteers" => $volunteers ?? null,
                "questions" => $questions,
                "partners" => $partners,
                "documents" => $documents,
                "links" => $links
            ]),
            "user" => $user ?? null,
        ]);
    }
}
