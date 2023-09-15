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
        $partners = $this->partnerModel->partners();
        $documents = $this->documentModel->index()["documents"];
        $questions = $this->questionModel->questions();

        $links = $this->linkModel->index();
        $latestEvent = $this->eventModel->getLatestEvent();



        echo $this->renderer->render("Layout.php", [
            "content" => $this->renderer->render("/pages/public/Content.php", [
                "volunteers" => $volunteers ?? null,
                "partners" => $partners ?? null,
                "documents" => $documents ?? null,
                "links" => $links ?? null,
                "latestEvent" => $latestEvent ?? null,
                "questions" => $questions ?? null
            ]),
            "user" => $user ?? null,
        ]);
    }
}
