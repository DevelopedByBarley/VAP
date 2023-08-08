<?php
class HomeController
{

    private $userModel;
    private $volunteerModel;
    private $questionModel;
    private $partnerModel;
    private $documentModel;
    private $linkModel;
    private $eventModel;


    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->volunteerModel = new VolunteerModel();
        $this->questionModel = new QuestionModel();
        $this->partnerModel = new PartnerModel;
        $this->documentModel = new DocumentModel();
        $this->linkModel = new LinkModel();
        $this->eventModel = new EventModel();

    }

    public function home()
    {
        session_start();


        $renderer = new Renderer();
        $user = $this->userModel->getMe();
        $volunteers = $this->volunteerModel->getVolunteers();
        $questions = $this->questionModel->questions();
        $partners = $this->partnerModel->partners();
        $documents = $this->documentModel->index();
        $links = $this->linkModel->index();
        $latestEvent = $this->eventModel->getLatestEvent();



        echo $renderer->render("Layout.php", [
            "content" => $renderer->render("/pages/Content.php", [
                "volunteers" => $volunteers ?? null,
                "links" => $links ?? null,
                "event" => $latestEvent ?? null,
                "questions" => $questions ?? null,
                "partners" => $partners,
                "documents" => $documents,
            ]),
            "user" => $user ?? null,
        ]);
    }
}
