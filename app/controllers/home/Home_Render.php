
<?php
require_once 'app/models/Gallery_Model.php';

class HomeRender extends HomeController
{
	protected $galleryModel;

	public function __construct()
	{
		parent::__construct();
		$this->galleryModel = new GalleryModel();
	}


	public function maintenance()
	{
		echo $this->renderer->render("pages/public/Maintenance.php", []);
	}


	public function errorPage()
	{
		session_start();

		$user =  $this->userModel->getMe();
		echo $this->renderer->render("Layout.php", [
			"title" => getStringByLang("404", "404", ""),
			"user" => $user,
			"content" => $this->renderer->render("/pages/error/404.php", [
				"user" => $user ?? null,
			]),
			"user" => $user ?? null,
		]);
	}


	public function cookieInfo()
	{
		session_start();

		$user =  $this->userModel->getMe();
		echo $this->renderer->render("Layout.php", [
			"nav" => [
				"link" => "/",
				"slug" => "Vissza a kezdőoldalra!"
			],
			"title" => getStringByLang("Süti info", "Cookie info", ""),
			"user" => $user,
			"content" => $this->renderer->render("/pages/public/Cookie_Info.php", [
				"user" => $user ?? null,
			]),
			"user" => $user ?? null,
		]);
	}

	public function partners()
	{
		session_start();
		$partners = $this->partnerModel->partners();

		$user =  $this->userModel->getMe();
		echo $this->renderer->render("Layout.php", [
			"title" => getStringByLang("Partnereink", "Partners", ""),
			"user" => $user,
			"content" => $this->renderer->render("/pages/public/Partners.php", [
				"user" => $user ?? null,

				"partners" => $partners ?? null,
			]),
			"user" => $user ?? null,
		]);
	}


	public function home()
	{
		session_start();

		if (!isset($_COOKIE["lang"])) {
			$this->languageService->language();
		}

		$user = $this->userModel->getMe();
		$volunteers = $this->volunteerModel->getVolunteers();
		$partners = $this->partnerModel->partners();
		$documents = $this->documentModel->index()["documents"];
		$questions = $this->questionModel->questions();

		$supportive_partners = array_filter($partners, function ($item) {
			return $item['type'] === 'support';
		});

		$cooperative_partners = array_filter($partners, function ($item) {
			return $item['type'] === 'cooperative';
		});


		$links = $this->linkModel->index();
		$events = $this->eventModel->getLatestEvents();
		$galleryImages = $this->galleryModel->getAllGalleryImages();
		$users = $this->userModel->all();
		$randomGalleryImages = array_slice($galleryImages, 0, count($galleryImages) > 3 ? 3 : count($galleryImages));
		$this->eventModel->setEventsPrivateIfExpired();




		echo $this->renderer->render("Layout.php", [
			"documents" => $documents ?? null,
			"title" => getStringByLang("Kezdőlap", "Home", ""),
			"content" => $this->renderer->render("/pages/public/Content.php", [
				"user" => $user ?? null,
				"volunteers" => $volunteers ?? null,
				"coop_partners" => $cooperative_partners ?? null,
				"sup_partners" => $supportive_partners ?? null,
				"documents" => $documents ?? null,
				"links" => $links ?? null,
				"latestEvents" => $events ?? null,
				"questions" => $questions ?? null,
				"galleryImages" => $galleryImages ?? null,
				'users' => $users ?? null,
				'events' => $events ?? null,
				'randomGalleryImages' => $randomGalleryImages ?? null,
			]),
			"user" => $user ?? null,
		]);
	}
}
