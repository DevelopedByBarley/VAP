<link rel="stylesheet" href="/public/css/content.css?v=<?php echo time() ?>" />
<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$volunteers = $params["volunteers"];
$sup_partners = $params["sup_partners"];
$coop_partners = $params["coop_partners"];
$documents = $params["documents"];
$links = $params["links"];
$latestEvents = $params["latestEvents"];



$questions = $params["questions"];

$user = $params["user"];
?>





<div class="container-fluid p-0 m-0">

	<!-- HEADER ROW -->
	<div class="row p-0 m-0">
		<div class="col-12 col-lg-7 d-flex align-items-center justify-content-center flex-column p-5 hero-section" id="header-intro">
			<div class="hero-content text-center">
				<h1 class="hero-title mb-4">
					<span class="text-gradient">Volunteer Art Programs</span>
				</h1>
				<p class="hero-description lead mb-4"><?= CONTENT["header"]["content"][$lang] ?? 'Problem' ?></p>
				<div class="hero-buttons d-flex flex-wrap justify-content-center gap-3">
					<?php if (!$user) : ?>
						<a href="/user/registration" class="btn btn-pink-gradient btn-lg px-4 py-3 shadow-lg">
							<i class="bi bi-person-plus me-2"></i>
							<?= CONTENT["header"]["reg_volunteer_btn"][$lang] ?? 'Problem' ?>
						</a>
					<?php endif ?>
					<?php if (!empty($latestEvents)) : ?>
						<a href="#latest-events" class="btn btn-outline-pink btn-lg px-4 py-3">
							<i class="bi bi-calendar-event me-2"></i>
							<?= CONTENT["header"]["next_event_btn"][$lang] ?? 'Problem' ?>
						</a>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-5 d-flex align-items-center justify-content-center flex-column hero-image" id="header-image">
			<div class="floating-elements">
				<div class="float-1"></div>
				<div class="float-2"></div>
				<div class="float-3"></div>
			</div>
		</div>
	</div>

	<!-- ABOUT US ROW-->

	<div class="row bg-dark text-light" id="about-us">
		<div class="col-12 d-flex align-items-center justify-content-center flex-column mt-5 mb-5 p-4" id="about-us-content">
			<h1 class="reveal text-uppercase"> <?= CONTENT["aboutUs"]["title"][$lang] ?? '' ?></h1>
			<hr class="line mt-1 mb-5 reveal">
			<p class="reveal px-1">
				<?= CONTENT["aboutUs"]["description"][1][$lang] ?? '' ?>
			</p>
			<p class="reveal px-1 mt-2">
				<?= CONTENT["aboutUs"]["description"][2][$lang] ?? '' ?>
			</p>
			<p class="reveal px-1 mt-2">
				<?= CONTENT["aboutUs"]["description"][3][$lang] ?? '' ?>
			</p>
		</div>
	</div>






	<!-- RECOMMENDATION ROW-->

	<div class="row d-flex flex-column-reverse flex-lg-row align-items-center justify-content-center" id="recommendation">
		<div class="col-12 col-lg-7 reveal py-5 text-center text-lg-start" id="recommendation-content">
			<h1 class="text-light mb-1 text-uppercase px-lg-5"><?= CONTENT["recommendation"]["title"][$lang] ?? 'HIBA' ?></h1>
			<p class="text-light text-start px-3 px-lg-5 mt-4">
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
			<h6 class="text-light text-lg-start">
				<?= CONTENT["advantages"]["content"][$lang] ?? 'HIBA' ?>
			</h6>
			<div class="text-start px-lg-3 mt-4 mt-lg-4">
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][1][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][2][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][3][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][4][$lang] ?? 'HIBA' ?></p>
				<p class="text-light">&#x2022; <?= CONTENT["advantages"]["advantages"][5][$lang] ?? 'HIBA' ?></p>
			</div>
		</div>
	</div>




	<!-- VOLUNTEERS ROW -->


	<div class="container p-0">
		<div class="row reveal mt-5 r-border" id="volunteers">
			<div class="col-xs-12">
				<div id="volunteers-header" class="mb-5">
					<h1 class="text-center mt-5 mb-4 text-uppercase"><?= CONTENT["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?></h1>
				</div>
				<div class="row" id="v-cards" style="min-height: 60vh">
					<?php foreach ($volunteers as $volunteer) : ?>
						<div class="col-xs-12 col-sm-6 col-lg-4 mt-2">
							<div class="card p-lg-4 volunteer-card r-border" style="width: 25rem;">
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




	<div class="container mt-5">
		<div class="row d-flex align-items-center justify-content-center" id="benefits" style="min-height: 600px;">
			<div class="col-12 reveal my-5">
				<h1 class="text-center mb-1 text-uppercase"><?= CONTENT["benefits"]["title"][$lang] ?></h1>
				<p class="text-center mb-2"><?= CONTENT["benefits"]["question"][$lang] ?></p>
			</div>
			<div class="row">
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem; min-height: 310px;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/team.png" style="width: 80px;" class="my-2" alt="">
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
							<img src="/public/assets/icons/binoculars.png" style="width: 80px;" class="my-2" alt="">
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
							<img src="/public/assets/icons/studying.png" style="width: 80px;" class="my-2" alt="">
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
	<?php if (!empty($latestEvents)) : ?>
		<div class="container p-0">
			<div class="row  mt-5 text-dark d-flex align-items-center justify-content-center r-border" id="latest-events" style="min-height: 500px;">
				<h1 class="text-center mb-5 text-uppercase"><?= CONTENT['events']['title'][$lang] ?></h1>
				<?php foreach ($latestEvents as $event) : ?>
					<div class="col-12">
						<div class="card-group event-card mb-4">
							<a class="w-100" href="/event/<?= $event["slug"] ?>" style="text-decoration: none;">
								<div class="card mb-0 p-3 border-0 mt-3">
									<div class="card-body py-1">
										<div class="row">
											<div class="col-12 col-xl-4">
												<img src="/public/assets/uploads/images/events/<?= $event["fileName"] ?>" alt="" class="img-fluid">
											</div>
											<div class="col-12 col-xl-8 p-0">
												<div class="d-flex flex-column">
													<h3 class="card-title text-uppercase mt-0 pr-color p-4 text-light">
														<strong><?= $event[languageSwitcher("name")] ?></strong>
													</h3>
													<div class="card-text text-dark mt-3">
														<?= $event[languageSwitcher("description")] ?>
													</div>
													<div class="text-dark my-3 d-lg-flex align-items-center justify-content-between">
														<h5>Esemény kezdete: <?= date("y/m/d", strtotime($event["date"])) ?></h5>
														<div class="mx-lg-5 mt-4 mt-lg-0"><img src="/public/assets/icons/vap_team.png" style="height: 100px; width: 150px;" /></div>

														</h5>

													</div>
												</div>
											</div>
										</div>
									</div>
							</a>

						</div>

					<?php endforeach ?>
					</div>
			</div>
		</div>
	<?php endif ?>

	<!-- GALLERY PROMOTION SECTION -->
	<div class="container-fluid py-5 mt-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12 col-lg-6">
					<div class="gallery-promo-content">
						<h2 class="display-5 fw-bold text-dark mb-4">
							<i class="bi bi-images text-pink me-3"></i>
							Tekintsd meg galériánkat
						</h2>
						<p class="lead text-muted mb-4">
							Fedezd fel programjaink és eseményeink legszebb pillanatait! 
							Böngészd át képgyűjteményünket, és lásd, milyen élményekben lehet részed nálunk.
						</p>
						<div class="d-flex flex-wrap gap-3 mb-4">
							<div class="feature-item d-flex align-items-center">
								<i class="bi bi-calendar-event text-pink me-2"></i>
								<span class="small text-muted">Esemény fotók</span>
							</div>
							<div class="feature-item d-flex align-items-center">
								<i class="bi bi-people text-pink me-2"></i>
								<span class="small text-muted">Közösségi pillanatok</span>
							</div>
							<div class="feature-item d-flex align-items-center">
								<i class="bi bi-heart text-pink me-2"></i>
								<span class="small text-muted">Inspiráló élmények</span>
							</div>
						</div>
						<a href="/gallery" class="btn btn-pink btn-lg px-4 py-3 shadow-sm">
							<i class="bi bi-collection me-2"></i>
							Galéria megtekintése
							<i class="bi bi-arrow-right ms-2"></i>
						</a>
					</div>
				</div>
				<div class="col-12 col-lg-6 mt-4 mt-lg-0">
					<div class="gallery-preview position-relative">
						<!-- Galéria előnézet grid -->
						<div class="row g-2">
							<div class="col-6">
								<div class="preview-item preview-large">
									<img src="/public/assets/uploads/images/gallery/sample1.jpg" 
										 alt="Galéria előnézet" 
										 class="img-fluid rounded shadow"
										 style="height: 200px; width: 100%; object-fit: cover;">
									<div class="preview-overlay">
										<i class="bi bi-zoom-in"></i>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="row g-2">
									<div class="col-12">
										<div class="preview-item">
											<img src="/public/assets/uploads/images/gallery/sample2.jpg" 
												 alt="Galéria előnézet" 
												 class="img-fluid rounded shadow"
												 style="height: 95px; width: 100%; object-fit: cover;">
											<div class="preview-overlay">
												<i class="bi bi-zoom-in"></i>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="preview-item">
											<img src="/public/assets/uploads/images/gallery/sample3.jpg" 
												 alt="Galéria előnézet" 
												 class="img-fluid rounded shadow"
												 style="height: 95px; width: 100%; object-fit: cover;">
											<div class="preview-overlay">
												<i class="bi bi-zoom-in"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- "Több kép" overlay -->
						<div class="more-images-overlay position-absolute top-0 end-0 m-3">
							<span class="badge bg-dark bg-opacity-75 px-3 py-2">
								<i class="bi bi-plus-circle me-1"></i>
								+100 kép
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		/* Rózsaszín színek definiálása */
		.text-pink {
			color: #e91e63 !important;
		}
		
		.btn-pink {
			background-color: #e91e63;
			border-color: #e91e63;
			color: white;
			transition: all 0.3s ease;
		}
		
		.btn-pink:hover {
			background-color: #c2185b;
			border-color: #c2185b;
			color: white;
			transform: translateY(-2px);
			box-shadow: 0 8px 20px rgba(233, 30, 99, 0.3);
		}
		
		.btn-pink:active,
		.btn-pink:focus {
			background-color: #ad1457;
			border-color: #ad1457;
			color: white;
			box-shadow: 0 0 0 0.2rem rgba(233, 30, 99, 0.25);
		}
		
		.gallery-promo-content {
			padding: 2rem 0;
		}
		
		.preview-item {
			position: relative;
			overflow: hidden;
			border-radius: 8px;
			cursor: pointer;
			transition: transform 0.3s ease;
		}
		
		.preview-item:hover {
			transform: scale(1.05);
		}
		
		.preview-overlay {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(233, 30, 99, 0.8);
			display: flex;
			align-items: center;
			justify-content: center;
			opacity: 0;
			transition: opacity 0.3s ease;
			color: white;
			font-size: 1.5rem;
		}
		
		.preview-item:hover .preview-overlay {
			opacity: 1;
		}
		
		.feature-item {
			background: rgba(255, 255, 255, 0.8);
			padding: 0.5rem 1rem;
			border-radius: 20px;
			border: 1px solid rgba(233, 30, 99, 0.2);
		}
		
		.more-images-overlay {
			z-index: 2;
		}
		
		@media (max-width: 768px) {
			.gallery-promo-content {
				text-align: center;
				padding: 1rem 0;
			}
			
			.feature-item {
				font-size: 0.875rem;
			}
		}
	</style>

					

	<!-- PARTNERS ROW -->

	<div class="row mt-5 reveal p-5 p-xxl-0" id="sup_partners">
		<div class="col-xs-12">
			<h1 class="text-center text-uppercase my-5"><?= CONTENT["partners"]["sup_partners"]["title"][$lang] ?? '' ?></h1>
			<div class="row mb-5">
				<?php $counter = 0; ?>
				<?php foreach ($sup_partners as $index => $partner) : ?>
					<?php if ($counter < 9) : ?>
						<a href="<?= $partner["link"] ?? '' ?>" class="co-12 col-sm-3 p-1 text-decoration-none text-dark mt-3 ">
							<div class="card p-2 border-0" style="width: 100%; min-height: 500px">
								<div class="d-flex align-items-center justify-content-center">
									<img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" class="w-100" alt="">
								</div>
								<div class="card-body p-0 my-3">
									<h4 class="my-3"><?= $partner["name"] ?></h4>
									<p class="card-text"><?= $partner[languageSwitcher("description")] ?></p>
								</div>
							</div>
						</a>

						<?php $counter++; ?>
					<?php endif; ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div class="row p-5 p-xxl-0 reveal" id="coop_partners">
		<div class="col-xs-12">
			<h1 class="text-center mt-5 mb-5 text-uppercase"><?= CONTENT["partners"]["coop_partners"]["title"][$lang] ?? '' ?></h1>
			<div class="row mb-5">
				<?php $counter = 0; ?>
				<?php foreach ($coop_partners as $index => $partner) : ?>
					<?php if ($counter < 9) : ?>

						<a href="<?= $partner["link"] ?? '' ?>" class="co-12 col-sm-3 mb-1 p-1 text-decoration-none text-dark mt-3 ">
							<div class="card p-2 border-0" style="width: 100%; min-height: 500px">
								<div class="d-flex align-items-center justify-content-center">
									<img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" class="w-100" alt="">
								</div>
								<div class="card-body p-0 my-3">
									<h4 class="my-3"><?= $partner["name"] ?></h4>
									<p class="card-text"><?= $partner[languageSwitcher("description")] ?></p>

								</div>
							</div>
						</a>
						<?php $counter++; ?>
					<?php endif; ?>
				<?php endforeach ?>
				<div class="text-center">
					<a href="/partners" class="btn btn-outline-dark"><?= CONTENT["partners"]["partner-btn"][$lang] ?? '' ?></a>
				</div>
			</div>
		</div>
	</div>





	<!-- FAQ ROW -->


	<div class="container p-0 shadow d-flex align-items-center justify-content-center flex-column border r-border reveal my-5" id="faq">
		<h1 class="text-center mt-5 mb-5 reveal text-uppercase"><?= CONTENT["faq"][$lang] ?? '' ?></h1>
		<div class="row w-100">
			<div class="col-xs-12 mb-5 reveal d-flex align-items-center justify-content-center flex-column p-0" style="min-height: 40vh;">
				<div class="accordion mb-5 w-100 " id="questionAccordion">
					<?php foreach ($questions as $index => $question) : ?>
						<div class="accordion-item ">
							<h2 class="accordion-header">
								<button style="font-size: 1.2rem" class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $question["q_id"] ?>"><?= $question[languageSwitcher("question")] ?> </button>
							</h2>
							<div id="collapse<?= $question["q_id"] ?>" class="accordion-collapse collapse hide">
								<div class="accordion-body" style="font-size: 1.2rem">
									<strong><?= $question[languageSwitcher("answer")] ?></strong>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>

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