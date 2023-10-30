<link rel="stylesheet" href="/public/css/content.css?v=<?php echo time() ?>">

<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$volunteers = $params["volunteers"];
$partners = $params["partners"];
$documents = $params["documents"];
$links = $params["links"];
$latestEvent = $params["latestEvent"];

$questions = $params["questions"];

$user = $params["user"];
?>


<div class="container-fluid">

	<!-- HEADER ROW -->

	<div class="row">
		<div class="col-12 col-lg-8 d-flex align-items-center justify-content-center flex-column p-5" id="header-intro">
			<h1 class="text-center mb-3"><span class="letters">V</span>olunteer <span class="letters">A</span>rt <span class="letters">P</span>rograms</h1>
			<p class="text-center"><?= CONTENT["header"]["content"][$lang] ?? 'Problem' ?></p>
			<?php if (!$user) : ?>
				<a href="/user/registration" class="btn pr-color btn text-light">Önkéntes regisztráció</a>
			<?php endif ?>


		</div>
		<div class="col-12 col-lg-4 d-flex align-items-center justify-content-center flex-column" id="header-image"></div>
	</div>

	<!-- ABOUT US ROW-->

	<div class="row bg-dark text-light" id="about-us">
		<div class="col-12 d-flex align-items-center justify-content-center flex-column mt-5 mb-5 p-4" id="about-us-content">
			<h1 class="reveal text-uppercase"> <?= CONTENT["aboutUs"]["title"][$lang] ?? '' ?></h1>
			<hr class="line mt-1 mb-5 reveal">
			<p id="about-me-dc" class="reveal">
				<?= CONTENT["aboutUs"]["description"][$lang] ?? '' ?>
			</p>
		</div>
	</div>


	<!-- RECOMMENDATION ROW-->

	<div class="row d-flex flex-column-reverse flex-lg-row align-items-center justify-content-center" id="recommendation">
		<div class="col-12 col-lg-7 reveal p-5 text-center" id="recommendation-content">
			<h1 class="text-light mb-1 text-uppercase"><?= CONTENT["recommendation"]["title"][$lang] ?? 'HIBA' ?></h1>
			<p class="text-light text-center text-lg-end px-lg-5 mt-4">
				<?= CONTENT["recommendation"]["content"][$lang] ?? 'HIBA' ?>
			</p>
		</div>
		<div class="col-12 col-lg-5" id="recommendation-bg"></div>
	</div>


	<!-- ADVANTAGES  ROW-->


	<div class="row d-flex align-items-center justify-content-center" id="advantages">
		<div class="col-12 col-lg-5" id="advantages-bg"></div>
		<div class="col-12 col-lg-7 reveal d-flex justify-content-center flex-column p-4 text-center">
			<h1 class="text-light text-uppercase text-lg-start mb-2"><?= CONTENT["advantages"]["title"][$lang] ?? 'HIBA' ?></h1>
			<h6 class="text-light text-lg-start text-uppercase">
				<?= CONTENT["advantages"]["content"][$lang] ?? 'HIBA' ?>
			</h6>
			<div class="text-start px-lg-3 mt-4 mt-lg-4">
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][1][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][2][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][3][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][4][$lang] ?? 'HIBA' ?></p>
			</div>
		</div>
	</div>




	<!-- VOLUNTEERS ROW -->


	<div class="container">
		<div class="row reveal mt-5 r-border" id="volunteers">
			<div class="col-xs-12">
				<div id="volunteers-header" class="mb-5">
					<h1 class="text-center mt-5 mb-4 text-uppercase"><?= CONTENT["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?></h1>
				</div>
				<div class="row d-flex align-items-center justify-content-center" id="v-cards" style="min-height: 60vh">
					<?php foreach ($volunteers as $volunteer) : ?>
						<div class="col-xs-12 col-sm-6 col-lg-4 d-flex align-items-center justify-content-center mt-2">
							<div class="card p-4 volunteer-card r-border" style="width: 25rem;">
								<div style="background: url(/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>) center center/cover" class="card-img-top volunteer-profile-image"> </div>
								<div class="card-body volunteer-card-body mt-3">
									<p class="card-text"><i class="bi bi-quote m-2" style="font-size: 1.2rem;"></i><?= $volunteer[languageSwitcher("description")]  ?></p>
									<hr>
									<i><?= $volunteer["name"] ?></i>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>



	<!-- TYPICAL TASKS ROW-->



	<div class="container mt-5">
		<div class="row d-flex align-items-center justify-content-center" id="benefits">
			<div class="col-12 mb-5 reveal">
				<h1 class="text-center mb-3 text-uppercase"><?= CONTENT["benefits"]["title"][$lang] ?></h1>
				<p class="text-center mb-5"><?= CONTENT["benefits"]["question"][$lang] ?></p>
			</div>
			<div class="row d-flex align-items-center justify-content-center">
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem; min-height: 310px;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/2.png" style="width: 80px;" alt="">
						</div>
						<div class="card-body">
							<h5 class="card-title text-center"><?= CONTENT["benefits"][1]["title"][$lang] ?></h5>
							<p class="card-text"><?= CONTENT["benefits"][1]["content"][$lang] ?></p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem; min-height: 310px;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/7.png" style="width: 80px;" alt="">
						</div>
						<div class="card-body">
							<h5 class="card-title text-center "><?= CONTENT["benefits"][2]["title"][$lang] ?></h5>
							<p class="card-text"><?= CONTENT["benefits"][2]["content"][$lang] ?></p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/5.png" style="width: 80px;" alt="">
						</div>
						<div class="card-body">
							<h5 class="card-title text-center"><?= CONTENT["benefits"][3]["title"][$lang] ?></h5>
							<p class="card-text"><?= CONTENT["benefits"][3]["content"][$lang] ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!-- PARALLAX ROW -->

	<div class="row">
		<div class="col-xs-12  p-0 m-0">
			<div id="parallax-wrapper" class="mb-5">
				<div class="mt-5 mb-5" id="parallax"></div>
				<div id="parallax-filter"></div>
			</div>

		</div>
	</div>


	<!--EVENT ROW -->
	<?php if ($latestEvent) : ?>
		<div class="container">
			<div class="row	mt-5 text-dark shadow d-flex align-items-center justify-content-center bg-dark r-border" id="latest-event" style="min-height: 700px;">
				<div class="col-12 col-sm-9 col-lg-6 p-4 reveal rounded" id="latest-event-title">
					<h1 class="mt-5 mb-2 text-light text-uppercase">Következő eseményünk</h1>
					<p class="text-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores ducimus, distinctio cumque doloremque animi id perferendis error aut est fugit esse architecto maxime! Non a iure expedita aut id totam, distinctio cumque doloremque animi id perferendis error aut est fugit esse architecto maxime! Non a iure expedita aut id totam.</p>
				</div>
				<div class="col-12 col-sm-6 col-lg-5 p-3 d-flex align-items-center justify-content-center text-dark reveal rounded">
					<a href="/event/<?= $latestEvent["eventId"] ?>" style="text-decoration: none;">
						<div class="card shadow-light bg-dark text-light border-0" id="event-card" style="width: 100%;">
							<div class="text-center">
								<img class="card-img-top r-border text-center mb-3" src="/public/assets/uploads/images/events/<?= $latestEvent["fileName"] ?>" style="height: 250px; width: 300px;" />
							</div>
							<div class="card-body">
								<h4 class="text-center"><?= $latestEvent[languageSwitcher("name")] ?></h4>
								<p class="card-text text-center"><b><?= date("Y/m/d",  strtotime($latestEvent["date"])) ?> - <?= date("Y/m/d",  strtotime($latestEvent["end_date"])) ?> </b></p>
								<hr style="border: 2px solid white">
								<p class="card-text"><?= $latestEvent[languageSwitcher("description")] ?></p>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	<?php endif ?>



	<!-- PARTNERS ROW -->

	<div class="row mt-5 reveal" id="partners">
		<div class="col-xs-12">
			<h1 class="text-center mt-5 mb-5 text-uppercase"><?= CONTENT["partners"]["title"][$lang] ?? '' ?></h1>
			<div class="row mb-5 d-flex align-items-center justify-content-center p-3">
				<?php $counter = 0; ?>
				<?php foreach ($partners as $index => $partner) : ?>
					<?php if ($counter < 9) : ?>
							<a href="<?= $partner["link"] ?? '' ?>" class="card p-2 m-4 shadow d-flex align-items-center justify-content-center text-decoration-none text-dark" style="max-width: 540px; min-height: 150px;">
								<div class="row g-0">
									<div class="col-md-4 d-flex align-items-center justify-content-center">
										<div style="background: url('/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>') center center/cover; height: 100px; width: 100px;" class="card-img-top"></div>
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h5 class="card-title"><?= $partner["name"] ?></h5>
											<p class="card-text"><?= $partner[languageSwitcher("description")] ?></p>
										</div>
									</div>
								</div>
							</a>
						</a>

						<?php $counter++; ?>
					<?php endif; ?>
				<?php endforeach ?>
				<div class="text-center">
					<a href="/partners" class="btn btn-outline-primary mt-5"><?= CONTENT["partners"]["partner-btn"][$lang] ?? '' ?></a>
				</div>
			</div>
		</div>
	</div>





	<!-- FAQ ROW -->


	<div class="container shadow d-flex align-items-center justify-content-center flex-column border r-border reveal mb-5" id="faq">
		<h1 class="text-center mt-5 mb-5 reveal text-uppercase"><?= CONTENT["faq"][$lang] ?? '' ?></h1>
		<div class="row w-100">
			<div class="col-xs-12 mb-5 reveal d-flex align-items-center justify-content-center flex-column" style="min-height: 40vh;">
				<div class="accordion mb-5" id="questionAccordion">
					<?php foreach ($questions as $index => $question) : ?>
						<div class="accordion-item">
							<h2 class="accordion-header">
								<button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $question["q_id"] ?>">
									<?= $question[languageSwitcher("question")] ?> </button>
							</h2>
							<div id="collapse<?= $question["q_id"] ?>" class="accordion-collapse collapse hide">
								<div class="accordion-body">
									<strong><?= $question[languageSwitcher("answer")] ?></strong>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>


	<!-- DOCUMENTS AND LINK-->

	<div class="row mt-5 align-items-center justify-content-center bg-dark text-light">
		<div class="col-12 col-sm-7 p-3 d-flex align-items-center justify-content-center flex-column reveal" style="min-height: 60vh">
			<h1 class="text-center mb-2 text-uppercase"><?= CONTENT["documents"]["title"][$lang] ?? 'HIBA' ?></h1>
			<p class="text-center" style="width: 75%; margin: 0 auto">
				<?= CONTENT["documents"]["content"][$lang] ?? 'HIBA' ?>
			</p>
			<div class="btn-group mt-3">
				<button class="btn pr-color text-light m-2" data-bs-toggle="modal" data-bs-target="#documentModal"><?= CONTENT["documents"]["d-button"][$lang] ?? 'HIBA' ?></button>
				<button class="btn sc-color text-light m-2" data-bs-toggle="modal" data-bs-target="#linksModal"><?= CONTENT["documents"]["l-button"][$lang] ?? 'HIBA' ?></button>
			</div>
		</div>
		<div class="col-12 col-sm-5 h-100" style="min-height: 60vh; background: url(/public/assets/images/2.jpg) center center/cover"></div>
	</div>


	<?php include './app/views/includes/Footer.php' ?>

</div>




<div class="modal fade" id="documentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"><?= CONTENT["documents"]["title"][$lang] ?? 'HIBA' ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php if (count($documents) === 0) : ?>
					<h6><?= CONTENT["documents"]["modal"]["no_documents"][$lang] ?? 'HIBA' ?></h6>
				<?php else : ?>
					<?php foreach ($documents as $index => $document) : ?>
						<p><a class="link-offset-2 link-underline link-underline-opacity-10" href="/public/assets/uploads/documents/admin/<?= $document["fileName"] ?>" download><?= $document[languageSwitcher("name")] ?></a></p>
					<?php endforeach ?>
				<?php endif ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="linksModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"><?= CONTENT["documents"]["l-button"][$lang] ?? 'HIBA' ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php if (count($links) === 0) : ?>
					<h6><?= CONTENT["documents"]["modal"]["no_links"][$lang] ?? 'HIBA' ?></h6>
				<?php else : ?>

					<?php foreach ($links as $index => $link) : ?>
						<p><a class="link-offset-2 link-underline link-underline-opacity-10" href="<?= $link["link"] ?>" target="_blank"><?= $link[languageSwitcher("name")] ?></a></p>
					<?php endforeach ?>

				<?php endif ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>