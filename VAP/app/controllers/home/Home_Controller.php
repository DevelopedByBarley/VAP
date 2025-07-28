<?php
require_once 'app/services/LanguageService.php';

class HomeController
{

    protected $renderer;
    protected $userModel;
    protected $volunteerModel;
    protected $questionModel;
    protected $partnerModel;
    protected $documentModel;
    protected $linkModel;
    protected $eventModel;
    protected $languageService;


    public function __construct()
    {
        $this->renderer = new Renderer();
        $this->userModel = new UserModel();
        $this->volunteerModel = new VolunteerModel();
        $this->questionModel = new QuestionModel();
        $this->partnerModel = new PartnerModel;
        $this->documentModel = new DocumentModel();
        $this->linkModel = new LinkModel();
        $this->eventModel = new EventModel();
        $this->languageService = new LanguageService();
    }

    // PUBLIC

    // SET LANGUAGE WITH MODAL
    public function setLanguage()
    {
        $browser_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        // Az első preferált nyelv kinyerése a listából
        $preferred_languages = explode(',', $browser_language);
        $language = strtolower(trim($preferred_languages[0]));     
        $this->languageService->language($_POST, $language );
        header('Location: /');
    }

    // SWITCH LANGUAGE
    public function switchLanguage($vars)
    {
        $this->languageService->switch($vars["lang"]);
    }
}
