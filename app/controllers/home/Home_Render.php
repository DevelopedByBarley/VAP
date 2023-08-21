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
        $latestEvent = $this->eventModel->getLatestEvent();



        echo $this->renderer->render("Layout.php", [
            "content" => $this->renderer->render("/pages/Content.php", [
                "volunteers" => $volunteers ?? null,
                "questions" => $questions ?? null,
                "partners" => $partners ?? null,
                "documents" => $documents ?? null,
                "links" => $links ?? null,
                "latestEvent" => $latestEvent ?? null
            ]),
            "user" => $user ?? null,
        ]);
    }
}
