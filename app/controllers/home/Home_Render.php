<?php
class HomeRender extends HomeController
{


    public function __construct()
    {
        parent::__construct();
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
