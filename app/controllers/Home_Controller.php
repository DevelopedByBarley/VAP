<?php
class HomeController
{

    private $userModel;
    private $volunteerModel;
    private $questionModel;
    private $partnerModel;
    private $documentModel;
    private $linkModel;


    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->volunteerModel = new VolunteerModel();
        $this->questionModel = new QuestionModel();
        $this->partnerModel = new PartnerModel;
        $this->documentModel = new DocumentModel();
        $this->linkModel = new LinkModel();

    }

    public function home()
    {
        $renderer = new Renderer();
        session_start();
        $user = $this->userModel->getMe();
        $volunteers = $this->volunteerModel->getVolunteers();
        $questions = $this->questionModel->questions();
        $partners = $this->partnerModel->partners();
        $documents = $this->documentModel->index();
        $links = $this->linkModel->index();


        $nameInLang = "nameIn" . $_COOKIE["lang"];
        $descriptionInLang = "descriptionIn" . $_COOKIE["lang"];
        $questionInLang = "questionIn" . $_COOKIE["lang"];
        $answerInLang = "answerIn" . $_COOKIE["lang"];



        echo $renderer->render("Layout.php", [
            "content" => $renderer->render("/pages/Content.php", [
                "volunteers" => $volunteers ?? null,
                "descriptionInLang" => $descriptionInLang ?? null,
                "questions" => $questions,
                "questionInLang" => $questionInLang,
                "answerInLang" => $answerInLang,
                "partners" => $partners,
                "documents" => $documents,
                "nameInLang" => $nameInLang,
                "links" => $links
            ]),
            "user" => $user ?? null,
        ]);
    }
}
