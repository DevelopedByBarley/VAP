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
    public function setLanguage()
    {
        $this->languageService->language($_POST);
    }

    public function switchLanguage($vars)
    {
        $this->languageService->switch($vars["lang"]);
    }
}
