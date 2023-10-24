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
			<p class="text-center">Volunteering in Art Programs is a platform where if you are interested in the visual arts, you can volunteer for multiple art projects and events with a single registration.</p>
			<?php if (!$user) : ?>
				<a href="/user/registration" class="btn pr-color btn text-light">Önkéntes regisztráció</a>
			<?php endif ?>


		</div>
		<div class="col-12 col-lg-4 d-flex align-items-center justify-content-center flex-column" id="header-image"></div>
	</div>

	<!-- ABOUT US ROW-->

	<div class="row bg-dark text-light" id="about-us">
		<div class="col-12 d-flex align-items-center justify-content-center flex-column mt-5 mb-5 p-4" id="about-us-content">
			<h1 class="reveal"> <?= CONTENT["aboutUs"]["title"][$lang] ?? '' ?></h1>
			<hr class="line mt-1 mb-5 reveal">
			<p id="about-me-dc" class="reveal">
				<?= CONTENT["aboutUs"]["description"][$lang] ?? '' ?>
			</p>
		</div>
	</div>


	<!-- RECOMMENDATION ROW-->

	<div class="row d-flex flex-column-reverse flex-lg-row align-items-center justify-content-center" id="recommendation">
		<div class="col-12 col-lg-7 reveal p-5 text-center" id="recommendation-content">
			<h1 class="text-light mb-1">Kiknek ajánljuk a programot?</h1>
			<p class="text-light text-center text-lg-end px-lg-5 mt-4">
				Minden művészet rajongónak, de kiemeltem NEKED, ha a kulturális szférában, azon belül képzőművészeti területen tanulsz vagy itt képzeled el a karriered és tapasztalatot, kapcsolatot szeretnél építeni intézmények, galériák képviselőivel, kulturális szakemberekkel, művészekkel.
			</p>
		</div>
		<div class="col-12 col-lg-5" id="recommendation-bg"></div>
	</div>


	<!-- ADVANTAGES  ROW-->


	<div class="row d-flex align-items-center justify-content-center" id="advantages">
		<div class="col-12 col-lg-5" id="advantages-bg"> </div>
		<div class="col-12 col-lg-7 reveal d-flex justify-content-center flex-column p-4 text-center">
			<h1 class="text-light">Jellemző feladatok</h1>
			<h5 class="text-light px-2">
				Eseményenként (kiállítás, vásár, fesztivál, galériában gyakornok) változnak a meghirdetett önkéntes pozíciók és feladatok, minden rendezvény előtt részletes leírást küldünk.
			</h5>
			<div class="text-start px-lg-5 mt-4 mt-lg-4">
				<p class="text-light">&#x2022; <b><u>Előkészítési feladatokban segítségnyújtás</u></b>: kiállításépítés; csomag összeállítás; helyszínekre szóróanyag kivitel; </p>
				<p class="text-light">&#x2022; <b><u>Rendezvényszervező asszisztens</u></b>: eseményeken ez előkészületekben részvétel, pl. helyszín dekoráció; vendégfogadás, regisztráció; ruhatár üzemeltetés; </p>
				<p class="text-light">&#x2022; <b><u>Programkoordinátor, túra kísérő önkéntes</u></b>: vendégek fogadása, regisztrációja és végig kísérése az útvonalon</p>
				<p class="text-light">&#x2022; <b><u>Kiállítás felügyelet</u></b></p>
			</div>
		</div>
	</div>




	<!-- VOLUNTEERS ROW -->


	<div class="container">
		<div class="row reveal mt-5 r-border" id="volunteers">
			<div class="col-xs-12">
				<div id="volunteers-header" class="mb-5">
					<h1 class="text-center mt-5 mb-4"><?= CONTENT["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?></h1>
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
		<div class="row d-flex align-items-center justify-content-center" id="typical-tasks">
			<div class="col-12 mb-5 reveal">
				<h1 class="text-center mb-3">Önkéntesség előnyei</h1>
				<p class="text-center mb-5">Milyen hasznos tudásra és előnyökre tehetsz szert a VAP programból? </p>
			</div>
			<div class="row d-flex align-items-center justify-content-center">
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem; min-height: 310px;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/2.png" style="width: 80px;" alt="">
						</div>
						<div class="card-body">
							<h5 class="card-title text-center">Izgalmas programok</h5>
							<p class="card-text">Önkéntesként színvonalas művészeti eseményekhez kötődő, izgalmas programokon vehetsz részt, amely élményszerűvé teszi a munkát.</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem; min-height: 310px;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/7.png" style="width: 80px;" alt="">
						</div>
						<div class="card-body">
							<h5 class="card-title text-center ">Betekintés</h5>
							<p class="card-text">Betekinthetsz a művészeti intézmények, galériák háttérmunkájába, művészek műtermébe.</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
					<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
						<div class="card-header text-center">
							<img src="/public/assets/icons/5.png" style="width: 80px;" alt="">
						</div>
						<div class="card-body">
							<h5 class="card-title text-center">Tanulás mellett</h5>
							<p class="card-text"> Évente több önkéntes lehetőséget kínálunk, ezek alkalmanként rövid távú tevékenységek, amelyek nem akadályoznak tanulmányaid vagy további elfoglaltságod elvégzésében.</p>
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
			<div class="row	mt-5 text-dark shadow d-flex align-items-center justify-content-center bg-dark r-border" id="latest-event">
				<div class="col-12 col-sm-9 col-lg-7 p-4 reveal rounded" id="latest-event-title">
					<h1 class="mt-5 mb-2 text-light">Következő eseményünk</h1>
					<p class="text-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores ducimus, distinctio cumque doloremque animi id perferendis error aut est fugit esse architecto maxime! Non a iure expedita aut id totam, distinctio cumque doloremque animi id perferendis error aut est fugit esse architecto maxime! Non a iure expedita aut id totam.</p>
					<a href="/events" class="btn btn-outline-light">További eseményeink</a>
				</div>
				<div class="col-12 col-sm-6 col-lg-4 p-3 d-flex align-items-center justify-content-center text-dark reveal rounded">
					<a href="/event/<?= $latestEvent["eventId"] ?>" style="text-decoration: none;">
						<div class="card shadow-light bg-dark text-light" id="event-card" style="width: 100%;">
							<div class="card-img-top r-border" style="height: 200px; width: 100%; background: url('/public/assets/uploads/images/events/<?= $latestEvent["fileName"] ?>') center center/cover;"></div>
							<div class="card-body">
								<h4 class="text-center"><?= $latestEvent[languageSwitcher("name")] ?></h4>
								<p class="card-text text-center"><i style="font-size: 1.5rem;" class="bi bi-calendar-check"></i> <b><?= $latestEvent["date"] ?> </b></p>
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
			<h1 class="text-center mt-5 mb-5"><?= CONTENT["partners"]["title"][$lang] ?? '' ?></h1>
			<div class="row mb-5 d-flex align-items-center justify-content-center p-3">
				<?php $counter = 0; ?>
				<?php foreach ($partners as $index => $partner) : ?>
					<?php if ($counter < 9) : ?>
						<div class="card p-2 m-4 shadow d-flex align-items-center justify-content-center" style="max-width: 540px; min-height: 150px;">
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
						</div>

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
		<h1 class="text-center mt-5 mb-5 reveal"><?= CONTENT["faq"][$lang] ?? '' ?></h1>
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


	<!-- DOCUMENTS AND LIN-->

	<div class="row mt-5 align-items-center justify-content-center bg-dark text-light">
		<div class="col-12 col-sm-7 p-3 d-flex align-items-center justify-content-center flex-column reveal" style="min-height: 60vh">
			<h1 class="text-center mb-2">További dokumentumok</h1>
			<p class="text-center" style="width: 75%; margin: 0 auto">
				Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non eaque omnis dolores nostrum tempora corporis delectus obcaecati! Temporibus, ea, cupiditate, dolor consequuntur omnis autem possimus dolorum exercitationem tempore sequi expedita!
			</p>
			<div class="btn-group mt-3">
				<button class="btn pr-color text-light m-2" data-bs-toggle="modal" data-bs-target="#documentModal">Hasznos anyagok</button>
				<button class="btn sc-color text-light m-2" data-bs-toggle="modal" data-bs-target="#linksModal">Hasznos linkek</button>
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
				<h5 class="modal-title" id="staticBackdropLabel">Hasznos anyagaink</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php if (count($documents) === 0) : ?>
					<h6>Nincs egy hasznos anyagunk sem most feltöltve</h6>
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
				<h5 class="modal-title" id="staticBackdropLabel">Hasznos linkjeink</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php if (count($links) === 0) : ?>
					<h6>Nincs egy hasznos linkünk sem most feltöltve</h6>
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