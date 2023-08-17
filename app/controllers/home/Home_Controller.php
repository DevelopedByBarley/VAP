<?php
class HomeController
{
    
    protected $renderer;
    protected $userModel;
    protected $volunteerModel;
    protected $questionModel;
    protected $partnerModel;
    protected $documentModel;
    protected $linkModel;


    public function __construct()
    {
        $this->renderer = new Renderer();
        $this->userModel = new UserModel();
        $this->volunteerModel = new VolunteerModel();
        $this->questionModel = new QuestionModel();
        $this->partnerModel = new PartnerModel;
        $this->documentModel = new DocumentModel();
        $this->linkModel = new LinkModel();

    }
}
