<?php
class HomeRender extends HomeController
{


	public function __construct()
	{
		parent::__construct();
	}

	public function partners()
	{
		session_start();
		$partners = $this->partnerModel->partners();

		$user =  $this->userModel->getMe();
		echo $this->renderer->render("Layout.php", [
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

		$links = $this->linkModel->index();
		$events = $this->eventModel->getLatestEvents();
		$this->eventModel->setEventsPrivateIfExpired();



		echo $this->renderer->render("Layout.php", [
			"content" => $this->renderer->render("/pages/public/Content.php", [
				"user" => $user ?? null,
				"volunteers" => $volunteers ?? null,
				"partners" => $partners ?? null,
				"documents" => $documents ?? null,
				"links" => $links ?? null,
				"latestEvents" => $events ?? null,
				"questions" => $questions ?? null
			]),
			"user" => $user ?? null,
		]);
	}

	public function success()
	{
		session_start();
		$lang = $_COOKIE["lang"] ?? null;
		$success = $_SESSION["success"] ?? null;
		$user = $this->userModel->getMe();

		echo $this->renderer->render("Layout.php", [
			"user" => $user,
			"content" => $this->renderer->render("/pages/public/Success.php", [
				"lang" => $lang,
				"title" => $success["title"] ?? '',
				"button_message" => $success["button_message"] ?? '',
				"message" => $success["message"] ?? '',
				"path" => $success["path"] ?? ''
			]),
		]);

		if (isset($_SESSION["success"])) unset($_SESSION["success"]);
	}
}
