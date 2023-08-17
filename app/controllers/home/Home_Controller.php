<?php
class HomeController
{

    protected $userModel;
    protected $volunteerModel;
    protected $questionModel;
    protected $partnerModel;
    protected $documentModel;
    protected $linkModel;


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
        $lang = $_COOKIE["lang"] ?? null;

        $nameInLang = "nameIn" . $lang;
        $descriptionInLang = "descriptionIn" . $lang;
        $questionInLang = "questionIn" . $lang;
        $answerInLang = "answerIn" . $lang;



        echo $renderer->render("Layout.php", [
            "content" => $renderer->render("/pages/Content.php", [
                "volunteers" => $volunteers ?? null,
                "descriptionInLang" => $descriptionInLang ?? null,
                "questions" => $questions ,
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
