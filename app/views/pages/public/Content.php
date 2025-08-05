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
$events = $params["events"] ?? [];

$user = $params["user"];
$user_count = $params["user_count"] ?? [];
$galleryImagesCount = count($params["galleryImages"] ?? 0);
$randomGalleryImages = $params["randomGalleryImages"] ?? [];
?>

<div class="container-fluid p-0 m-0">

	<!-- HEADER ROW -->
	<header class="row p-0 m-0 light-bg" itemscope itemtype="https://schema.org/Organization">
		<div class="col-12 col-lg-5 d-flex align-items-center justify-content-center flex-column hero-image" id="header-image">
			<div class="floating-elements" aria-hidden="true">
				<div class="float-1"></div>
				<div class="float-2"></div>
				<div class="float-3"></div>
			</div>
		</div>
		<div class="col-12 col-lg-7 d-flex align-items-center justify-content-center flex-column p-5 hero-section" id="header-intro">
			<div class="hero-content">
				<h1 class="hero-title mb-4 text-center text-xl-start" itemprop="name">
					<span class="volunteers-title" style="font-size: 3.5rem;">Volunteer Art Programs</span>
				</h1>
				<p class="hero-description lead mb-4 text-center text-xl-start" itemprop="description"><?= CONTENT["header"]["content"][$lang] ?? 'Problem' ?></p>
				<nav class="d-flex flex-wrap justify-content-center gap-3" aria-label="<?= $lang === 'Hu' ? 'Fő műveletek' : 'Main actions' ?>">
					<?php if (!$user) : ?>
						<a href="/user/registration" class="btn btn-pink rounded btn-lg px-4 py-3"
							aria-label="<?= CONTENT["header"]["reg_volunteer_btn"][$lang] ?? 'Register as volunteer' ?>">
							<i class="bi bi-person-plus me-2" aria-hidden="true"></i>
							<?= CONTENT["header"]["reg_volunteer_btn"][$lang] ?? 'Problem' ?>
						</a>
					<?php endif ?>
					<?php if (!empty($latestEvents)) : ?>
						<a href="#latest-events" class="btn btn-blue btn-lg rounded px-4 py-3"
							aria-label="<?= CONTENT["header"]["next_event_btn"][$lang] ?? 'View next event' ?>">
							<i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
							<?= CONTENT["header"]["next_event_btn"][$lang] ?? 'Problem' ?>
						</a>
					<?php endif ?>
				</nav>
			</div>
		</div>
</div>

<!-- ABOUT US ROW-->
<section class="row" id="about-us" itemscope itemtype="https://schema.org/AboutPage">
	<div class="col-12 col-lg-6 mx-auto text-center" id="about-us-content">
		<div class="about-us-text-container">
			<div class="about-us-icon" aria-hidden="true">
				<img src="/public/assets/icons/logo.png" alt="Volunteer Art Programs Logo" style="height: 80px; width: auto;">
			</div>
			<h2 class="about-us-title section-title reveal" itemprop="name">
				<?= CONTENT["aboutUs"]["title"][$lang] ?? '' ?>
			</h2>
			<div class="about-us-divider reveal" aria-hidden="true"></div>
			<div class="about-us-description" itemprop="description">
				<p class="reveal about-us-paragraph fs-5 fw-normal">
					<?= CONTENT["aboutUs"]["description"][1][$lang] ?? '' ?>
				</p>
				<p class="reveal about-us-paragraph fs-5 fw-normal">
					<?= CONTENT["aboutUs"]["description"][2][$lang] ?? '' ?>
				</p>
				<p class="reveal about-us-paragraph fs-5 fw-normal">
					<?= CONTENT["aboutUs"]["description"][3][$lang] ?? '' ?>
				</p>
			</div>
			<div class="about-us-stats reveal" itemscope itemtype="https://schema.org/Organization">
				<div class="stat-item">
					<div class="stat-number" itemprop="numberOfEmployees"><?= $user_count - 2 ?>+</div>
					<div class="stat-label"><?= CONTENT["stats"]["volunteers"][$lang] ?? 'Önkéntesek' ?></div>
				</div>
				<div class="stat-item">
					<div class="stat-number"><?= count($events) ?>+</div>
					<div class="stat-label"><?= CONTENT["stats"]["events"][$lang] ?? 'Események' ?></div>
				</div>
				<div class="stat-item">
					<div class="stat-number">5+</div>
					<div class="stat-label"><?= CONTENT["stats"]["experience"][$lang] ?? 'Év tapasztalat' ?></div>
				</div>
			</div>
		</div>
	</div>
</section>






<!-- RECOMMENDATION ROW-->

<div class="row d-flex flex-column-reverse flex-lg-row align-items-center justify-content-center" id="recommendation">
	<div class="col-12 col-lg-7 reveal py-5 text-center text-lg-start" id="recommendation-content">
		<div class="recommendation-text-wrapper">
			<!-- <div class="recommendation-badge">
						<i class="bi bi-star-fill me-2"></i>
						<span>Ajánlás</span>
					</div> -->
			<h1 class="recommendation-title text-center mb-4 text-uppercase">
				<?= CONTENT["recommendation"]["title"][$lang] ?? 'HIBA' ?>
			</h1>
			<div class="recommendation-quote">
				<div class="quote-icon">
					<i class="bi bi-quote"></i>
				</div>
				<p class="recommendation-text text-dark">
					<?= CONTENT["recommendation"]["content"][$lang] ?? 'HIBA' ?>
				</p>
				<div class="quote-author">
					<div class="author-line bg-secondary"></div>
					<span class="author-name text-dark"><?= CONTENT["recommendation"]["author"][$lang] ?? 'Volunteer Art Programs csapata' ?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-5" id="recommendation-bg"></div>
</div>
<!-- ADVANTAGES  ROW-->

<div class="row d-flex align-items-center justify-content-center" id="advantages">
	<div class="col-12 col-lg-10 mx-auto mt-3 text-center reveal">
		<h1 class="advantages-title text-uppercase mb-4 mt-5">
			<?= CONTENT["advantages"]["title"][$lang] ?? 'HIBA' ?>
		</h1>
	</div>
	<div class="col-12 col-lg-5 reveal">
		<!-- Advantages Carousel -->
		<div id="advantagesCarousel" class="carousel slide advantages-carousel" data-bs-ride="carousel" data-bs-interval="4000">
			<div class="carousel-indicators">
				<button type="button" data-bs-target="#advantagesCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="<?= $lang === 'Hu' ? 'Első kép' : 'First slide' ?>"></button>
				<button type="button" data-bs-target="#advantagesCarousel" data-bs-slide-to="1" aria-label="<?= $lang === 'Hu' ? 'Második kép' : 'Second slide' ?>"></button>
				<button type="button" data-bs-target="#advantagesCarousel" data-bs-slide-to="2" aria-label="<?= $lang === 'Hu' ? 'Harmadik kép' : 'Third slide' ?>"></button>
				<button type="button" data-bs-target="#advantagesCarousel" data-bs-slide-to="3" aria-label="<?= $lang === 'Hu' ? 'Negyedik kép' : 'Fourth slide' ?>"></button>
			</div>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img src="/public/assets/images/onkentes_foto.jpg" class="d-block w-100 carousel-image" alt="<?= $lang === 'Hu' ? 'Önkéntes munka' : 'Volunteer work' ?>">
					<div class="carousel-overlay">
						<!-- <div class="carousel-content">
								<h5 class="carousel-title"><?= $lang === 'Hu' ? 'Közösségi munka' : 'Community work' ?></h5>
								<p class="carousel-text"><?= $lang === 'Hu' ? 'Csatlakozz hozzánk és légy része egy nagyszerű közösségnek!' : 'Join us and be part of an amazing community!' ?></p>
							</div> -->
					</div>
				</div>
				<div class="carousel-item">
					<img src="/public/assets/images/gallery/<?= !empty($randomGalleryImages[0]["fileName"]) ? $randomGalleryImages[0]["fileName"] : 'default.jpg' ?>" class="d-block w-100 carousel-image" alt="<?= $lang === 'Hu' ? 'Galéria kép' : 'Gallery image' ?>">
					<div class="carousel-overlay">
						<!-- <div class="carousel-content">
								<h5 class="carousel-title"><?= $lang === 'Hu' ? 'Kreatív projektek' : 'Creative projects' ?></h5>
								<p class="carousel-text"><?= $lang === 'Hu' ? 'Művészeti projektek és kreatív tevékenységek' : 'Art projects and creative activities' ?></p>
							</div> -->
					</div>
				</div>
				<div class="carousel-item">
					<img src="/public/assets/images/gallery/<?= !empty($randomGalleryImages[1]["fileName"]) ? $randomGalleryImages[1]["fileName"] : 'default.jpg' ?>" class="d-block w-100 carousel-image" alt="<?= $lang === 'Hu' ? 'Közösségi esemény' : 'Community event' ?>">
					<div class="carousel-overlay">
						<!-- 	<div class="carousel-content">
								<h5 class="carousel-title"><?= $lang === 'Hu' ? 'Események' : 'Events' ?></h5>
								<p class="carousel-text"><?= $lang === 'Hu' ? 'Izgalmas események és programok' : 'Exciting events and programs' ?></p>
							</div> -->
					</div>
				</div>
				<div class="carousel-item">
					<img src="/public/assets/images/gallery/<?= !empty($randomGalleryImages[2]["fileName"]) ? $randomGalleryImages[2]["fileName"] : 'default.jpg' ?>" class="d-block w-100 carousel-image" alt="<?= $lang === 'Hu' ? 'Csapatmunka' : 'Teamwork' ?>">
					<div class="carousel-overlay">
						<!-- 	<div class="carousel-content">
								<h5 class="carousel-title"><?= $lang === 'Hu' ? 'Csapatmunka' : 'Teamwork' ?></h5>
								<p class="carousel-text"><?= $lang === 'Hu' ? 'Együttműködés és közös célok' : 'Cooperation and shared goals' ?></p>
							</div> -->
					</div>
				</div>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#advantagesCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden"><?= $lang === 'Hu' ? 'Előző' : 'Previous' ?></span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#advantagesCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden"><?= $lang === 'Hu' ? 'Következő' : 'Next' ?></span>
			</button>
		</div>
	</div>
	<div class="col-12 col-lg-7 reveal d-flex justify-content-center flex-column p-4 text-center">
		<div class="advantages-text-wrapper">
			<div class="advantages-description">
				<p class="advantages-intro text-dark text-lg-start">
					<?= CONTENT["advantages"]["content"][$lang] ?? 'HIBA' ?>
				</p>
			</div>

			<div class="advantages-list text-start px-lg-3 mt-4">
				<div class="advantage-item">
					<div class="advantage-bullet">
						<i class="bi bi-check-circle-fill pr-text-color"></i>
					</div>
					<p class="advantage-text text-dark">
						<?= CONTENT["advantages"]["advantages"][1][$lang] ?? 'HIBA' ?>
					</p>
				</div>
				<div class="advantage-item">
					<div class="advantage-bullet">
						<i class="bi bi-check-circle-fill pr-text-color"></i>
					</div>
					<p class="advantage-text text-dark">
						<?= CONTENT["advantages"]["advantages"][2][$lang] ?? 'HIBA' ?>
					</p>
				</div>
				<div class="advantage-item">
					<div class="advantage-bullet">
						<i class="bi bi-check-circle-fill pr-text-color"></i>
					</div>
					<p class="advantage-text text-dark">
						<?= CONTENT["advantages"]["advantages"][3][$lang] ?? 'HIBA' ?>
					</p>
				</div>
				<div class="advantage-item">
					<div class="advantage-bullet">
						<i class="bi bi-check-circle-fill pr-text-color"></i>
					</div>
					<p class="advantage-text text-dark">
						<?= CONTENT["advantages"]["advantages"][4][$lang] ?? 'HIBA' ?>
					</p>
				</div>
				<div class="advantage-item">
					<div class="advantage-bullet">
						<i class="bi bi-check-circle-fill pr-text-color"></i>
					</div>
					<p class="advantage-text text-dark">
						<?= CONTENT["advantages"]["advantages"][5][$lang] ?? 'HIBA' ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- VOLUNTEERS ROW -->

<div class="volunteers-section">
	<div class="container p-0">
		<div class="row reveal mt-5" id="volunteers">
			<div class="col-xs-12">
				<div id="volunteers-header" class="mb-5">
					<!-- <div class="volunteers-badge">
						<i class="bi bi-people-fill me-2"></i>
						<span><?= CONTENT["team"]["badge"][$lang] ?? 'Csapatunk' ?></span>
					</div> -->
					<h1 class="volunteers-title text-center mb-4 text-uppercase">
						<?= CONTENT["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?>
					</h1>
					<div class="volunteers-subtitle">
						<p class="text-center text-muted"><?= CONTENT["team"]["description"][$lang] ?? 'Ismerje meg az elkötelezett önkénteseinket, akik szenvedélyesen dolgoznak a művészeti programokért' ?></p>
					</div>
				</div>
				<div class="row justify-content-center" id="v-cards" style="min-height: 60vh">
					<?php foreach ($volunteers as $volunteer) : ?>
						<div class="col-xs-12 col-sm-6 col-lg-4 mt-3 d-flex justify-content-center">
							<div class="volunteer-card-modern">
								<div class="volunteer-image-container">
									<div style="background: url(/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>) center center/cover" class="volunteer-profile-image-modern"></div>
									<div class="volunteer-overlay">
										<div class="volunteer-quote-icon">
											<i class="bi bi-quote"></i>
										</div>
									</div>
								</div>
								<div class="volunteer-content">
									<div class="volunteer-quote">
										<p class="volunteer-description">
											<?= $volunteer[languageSwitcher("description")]  ?>
										</p>
									</div>
									<div class="volunteer-author">
										<div class="author-divider"></div>
										<span class="volunteer-name"><?= $volunteer["name"] ?></span>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- BENEFITS SECTION -->
<div class="benefits-section">
	<div class="container">
		<div class="benefits-header reveal">
			<!-- <div class="benefits-badge">
				<i class="bi bi-star-fill"></i>
				<span><?= CONTENT["benefits"]["badge"][$lang] ?? 'Előnyök' ?></span>
			</div> -->
			<h1 class="benefits-title">
				<?= CONTENT["benefits"]["title"][$lang] ?>
			</h1>
			<p class="benefits-subtitle">
				<?= CONTENT["benefits"]["question"][$lang] ?>
			</p>
		</div>

		<div class="row justify-content-center g-4">
			<div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center reveal">
				<div class="benefit-card-modern">
					<div class="benefit-icon-container">
						<div class="benefit-icon-wrapper">
							<img src="/public/assets/icons/team.png" class="benefit-icon" alt="">
						</div>
						<div class="benefit-decoration"></div>
					</div>
					<div class="benefit-content">
						<h5 class="benefit-title"><?= CONTENT["benefits"][1]["title"][$lang] ?></h5>
						<p class="benefit-description"><?= CONTENT["benefits"][1]["content"][$lang] ?></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center reveal">
				<div class="benefit-card-modern">
					<div class="benefit-icon-container">
						<div class="benefit-icon-wrapper">
							<img src="/public/assets/icons/binoculars.png" class="benefit-icon" alt="">
						</div>
						<div class="benefit-decoration"></div>
					</div>
					<div class="benefit-content">
						<h5 class="benefit-title"><?= CONTENT["benefits"][2]["title"][$lang] ?></h5>
						<p class="benefit-description"><?= CONTENT["benefits"][2]["content"][$lang] ?></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center reveal">
				<div class="benefit-card-modern">
					<div class="benefit-icon-container">
						<div class="benefit-icon-wrapper">
							<img src="/public/assets/icons/studying.png" class="benefit-icon" alt="">
						</div>
						<div class="benefit-decoration"></div>
					</div>
					<div class="benefit-content">
						<h5 class="benefit-title"><?= CONTENT["benefits"][3]["title"][$lang] ?></h5>
						<p class="benefit-description"><?= CONTENT["benefits"][3]["content"][$lang] ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- PARALLAX ROW -->

<div class="row">
	<div class="col-xs-12 p-0 m-0">
		<div id="parallax-wrapper" class="mb-5">
			<div class="mb-5" id="parallax"></div>
			<div id="parallax-filter"></div>
		</div>

	</div>
</div>


<!--EVENTS SECTION -->
<?php if (!empty($latestEvents)) : ?>
	<div class="events-section py-5" id="latest-events">
		<div class="container">
			<div class="events-header text-center mb-5 reveal">
				<!-- <div class="partners-badge mb-3">
					<i class="bi bi-calendar-event"></i>
					<span><?= CONTENT["upcoming_events"]["badge"][$lang] ?? 'Közelgő események' ?></span>
				</div> -->
				<h1 class="events-title text-uppercase">
					<?= CONTENT['events']['title'][$lang] ?>
				</h1>
				<p class="events-subtitle">
					Ne maradj le legújabb programjainkról és eseményeinkről
				</p>
			</div>

			<div class="row justify-content-center g-4">
				<?php foreach ($latestEvents as $event) : ?>
					<div class="col-12 d-flex justify-content-center reveal">
						<div class="event-card-horizontal">
							<div class="row g-0 h-100">
								<div class="col-md-4  d-flex justify-content-center align-items-center">
									<div class="event-image-container">
										<img src="/public/assets/uploads/images/events/<?= $event["fileName"] ?>"
											alt="<?= $event[languageSwitcher("name")] ?>"
											class=" img-fluid">
										<!-- Dátum badge eltávolítva -->
									</div>
								</div>
								<div class="col-md-8">
									<div class="event-content">
										<div class="event-header">
											<h3 class="event-title"><?= $event[languageSwitcher("name")] ?></h3>
											<div class="event-date-info">
												<?php
												// Magyar hónapnevek
												$hungarianMonths = [
													'January' => 'január',
													'February' => 'február',
													'March' => 'március',
													'April' => 'április',
													'May' => 'május',
													'June' => 'június',
													'July' => 'július',
													'August' => 'augusztus',
													'September' => 'szeptember',
													'October' => 'október',
													'November' => 'november',
													'December' => 'december'
												];

												// Dátum tartomány generálása a date és end_date mezőkből
												$startDate = $event["date"];
												$endDate = $event["end_date"] ?? $event["date"];

												if ($startDate === $endDate) {
													// Egynapos esemény
													$monthEn = date("F", strtotime($startDate));
													$monthHu = $lang === 'Hu' ? $hungarianMonths[$monthEn] : $monthEn;
													$eventDate = date("Y", strtotime($startDate)) . ". " . $monthHu . " " . date("j", strtotime($startDate)) . ".";
												} else {
													// Többnapos esemény
													if (date("Y-m", strtotime($startDate)) === date("Y-m", strtotime($endDate))) {
														// Ugyanabban a hónapban
														$startDay = date("j", strtotime($startDate));
														$endDay = date("j", strtotime($endDate));
														$monthEn = date("F", strtotime($startDate));
														$monthHu = $lang === 'Hu' ? $hungarianMonths[$monthEn] : $monthEn;
														$year = date("Y", strtotime($startDate));
														$eventDate = $year . ". " . $monthHu . " " . $startDay . "-" . $endDay . ".";
													} else {
														// Különböző hónapokban
														$startMonthEn = date("F", strtotime($startDate));
														$endMonthEn = date("F", strtotime($endDate));
														$startMonthHu = $lang === 'Hu' ? $hungarianMonths[$startMonthEn] : $startMonthEn;
														$endMonthHu = $lang === 'Hu' ? $hungarianMonths[$endMonthEn] : $endMonthEn;

														$startFormatted = date("Y", strtotime($startDate)) . ". " . $startMonthHu . " " . date("j", strtotime($startDate)) . ".";
														$endFormatted = date("Y", strtotime($endDate)) . ". " . $endMonthHu . " " . date("j", strtotime($endDate)) . ".";
														$eventDate = $startFormatted . " - " . $endFormatted;
													}
												}
												?>
												<span class="event-date-display">
													<i class="bi bi-calendar3 me-2"></i>
													<?= $eventDate ?>
												</span>
											</div>

										</div>
										<div class="event-description">
											<p>
												<?= $event[languageSwitcher("description")] ?>
											</p>
										</div>
										<div class="event-footer">
											<a href="/event/<?= $event["slug"] ?>" class="event-link">

												<div class="event-cta">
													<span class="read-more"><?= CONTENT["upcoming_events"]["details"][$lang] ?? 'Részletek' ?></span>
													<i class="bi bi-arrow-right"></i>
												</div>
											</a>
											<a href="/gallery" class="event-link">

												<div class="event-cta">
													<span class="read-more"><?= CONTENT["upcoming_events"]["gallery_btn"][$lang] ?? 'Galéria' ?></span>
													<i class="bi bi-arrow-right"></i>
												</div>
											</a>
											<div class="event-logo">
												<img src="/public/assets/icons/vap_team.png" alt="VAP Team">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
<?php endif ?>

<div class="container-fluid py-5 mt-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);" id="gallery">
	<div class="container py-5">
		<div class="row align-items-center">
			<div class="col-12 col-lg-6">
				<div class="gallery-promo-content">
					<h2 class="display-5 fw-bold gallery-title mb-4 ">
						<i class="bi bi-images text-pink me-3"></i>
						<?= CONTENT["gallery_section"]["title"][$lang] ?? 'TEKINTSD MEG GALÉRIÁNKAT' ?>
					</h2>
					<p class="lead text-muted mb-4">
						<?= CONTENT["gallery_section"]["description"][$lang] ?? 'Fedezd fel programjaink és eseményeink legszebb pillanatait! Böngészd át képgyűjteményünket, és lásd, milyen élményekben lehet részed nálunk.' ?>
					</p>
					<!-- 					<div class="d-flex flex-wrap gap-3 mb-4">
						<div class="feature-item d-flex align-items-center">
							<i class="bi bi-calendar-event text-pink me-2"></i>
							<span class="small text-muted"><?= CONTENT["gallery_section"]["features"]["event_photos"][$lang] ?? 'Esemény fotók' ?></span>
						</div>
						<div class="feature-item d-flex align-items-center">
							<i class="bi bi-people text-pink me-2"></i>
							<span class="small text-muted"><?= CONTENT["gallery_section"]["features"]["community_moments"][$lang] ?? 'Közösségi pillanatok' ?></span>
						</div>
						<div class="feature-item d-flex align-items-center">
							<i class="bi bi-heart text-pink me-2"></i>
							<span class="small text-muted"><?= CONTENT["gallery_section"]["features"]["inspiring_experiences"][$lang] ?? 'Inspiráló élmények' ?></span>
						</div>
					</div> -->
					<a href="/gallery" class="btn btn-pink btn-lg px-4 py-3 shadow-sm">
						<i class="bi bi-collection me-2"></i>
						<?= CONTENT["gallery_section"]["view_gallery_btn"][$lang] ?? 'Galéria megtekintése' ?>
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
								<img src="/public/assets/images/gallery/<?= $randomGalleryImages[0]["fileName"] ?? '' ?>"
									alt="Galéria előnézet"
									class="img-fluid rounded shadow"
									style="height: 200px; width: 100%; object-fit: cover;">
							</div>
						</div>
						<div class="col-6">
							<div class="row g-2">
								<div class="col-12">
									<div class="preview-item">
										<img src="/public/assets/images/gallery/<?= $randomGalleryImages[1]["fileName"] ?? '' ?>"
											alt="Galéria előnézet"
											class="img-fluid rounded shadow"
											style="height: 95px; width: 100%; object-fit: cover;">

									</div>
								</div>
								<div class="col-12">
									<div class="preview-item">
										<img src="/public/assets/images/gallery/<?= $randomGalleryImages[2]["fileName"] ?? '' ?>"
											alt="Galéria előnézet"
											class="img-fluid rounded shadow"
											style="height: 95px; width: 100%; object-fit: cover;">
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- "Több kép" overlay -->
					<div class="more-images-overlay position-absolute top-0 end-0 m-3">
						<span class="badge bg-dark bg-opacity-75 px-3 py-2">
							<i class="bi bi-plus-circle me-1"></i>
							<?= $galleryImagesCount - 1 ?> + <?= CONTENT["gallery_section"]["more_images"][$lang] ?? 'Kép' ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





<!-- PARTNERS ROW -->

<!-- PARTNERS SECTION -->
<div class="partners-section py-5">
	<div class="container">
		<!-- Supporting Partners -->
		<div class="partners-category mb-5 reveal my-5" id="sup_partners">
			<div class="partners-header text-center mb-5">
				<!-- <div class="partners-badge mb-3">
					<i class="bi bi-people"></i>
					<span><?= CONTENT["partners"]["sup_partners"]["badge"][$lang] ?? 'Támogatók' ?></span>
				</div> -->
				<h2 class="volunteers-title text-center mb-4 text-uppercase">
					<?= CONTENT["partners"]["sup_partners"]["title"][$lang] ?? '' ?>
				</h2>
			</div>

			<br>

			<div class="row g-4 justify-content-center">
				<?php $counter = 0; ?>
				<?php foreach ($sup_partners as $index => $partner) : ?>
					<?php if ($counter < 9) : ?>
						<div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
							<div class="partner-card-modern">
								<a href="<?= $partner["link"] ?? '' ?>" class="partner-link">
									<div class="partner-image-container">
										<img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>"
											alt="<?= $partner["name"] ?>"
											class="partner-image">
									</div>
									<div class="partner-content">
										<h5 class="partner-name"><?= $partner["name"] ?></h5>
										<p class="partner-description"><?= $partner[languageSwitcher("description")] ?></p>
									</div>
								</a>
							</div>
						</div>
						<?php $counter++; ?>
					<?php endif; ?>
				<?php endforeach ?>
			</div>
		</div>

		<br>

		<!-- Cooperation Partners -->
		<div class="partners-category reveal my-5" id="coop_partners">
			<div class="partners-header text-center mb-5">
				<!-- <div class="partners-badge mb-3">
					<i class="bi bi-people"></i>
					<span><?= CONTENT["partners"]["coop_partners"]["badge"][$lang] ?? 'Együttműködők' ?></span>
				</div> -->
				<h2 class="volunteers-title text-center text-uppercase">
					<?= CONTENT["partners"]["coop_partners"]["title"][$lang] ?? '' ?>
				</h2>
			</div>

			<div class="row g-4 justify-content-center">
				<?php $counter = 0; ?>
				<?php foreach ($coop_partners as $index => $partner) : ?>
					<?php if ($counter < 9) : ?>
						<div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
							<div class="partner-card-modern">
								<a href="<?= $partner["link"] ?? '' ?>" class="partner-link">
									<div class="partner-image-container">
										<img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>"
											alt="<?= $partner["name"] ?>"
											class="partner-image">
									</div>
									<div class="partner-content">
										<h5 class="partner-name"><?= $partner["name"] ?></h5>
										<p class="partner-description"><?= $partner[languageSwitcher("description")] ?></p>
									</div>
								</a>
							</div>
						</div>
						<?php $counter++; ?>
					<?php endif; ?>
				<?php endforeach ?>
			</div>

			<div class="text-center mt-5">
				<a href="/partners" class="btn btn-pink btn-lg px-4 py-3">
					<i class="bi bi-arrow-right me-2"></i>
					<?= CONTENT["partners"]["partner-btn"][$lang] ?? '' ?>
				</a>
			</div>
		</div>
	</div>
</div>




<!-- FAQ ROW -->


<div class="container p-0 d-flex align-items-center justify-content-center flex-column  reveal my-5" id="faq">
	<h1 class="volunteers-title text-center mb-4 text-uppercase"><?= CONTENT["faq"][$lang] ?? '' ?></h1>
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

<!-- SEO Structured Data for Events -->
<?php if (!empty($events)) : ?>
	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "ItemList",
			"name": "<?= CONTENT["events"]["title"][$lang] ?? 'Events' ?>",
			"itemListElement": [
				<?php foreach ($events as $index => $event) : ?> {
						"@type": "Event",
						"name": "<?= htmlspecialchars($event[languageSwitcher("name")]) ?>",
						"description": "<?= htmlspecialchars(strip_tags($event[languageSwitcher("description")])) ?>",
						"startDate": "<?= $event['event_date'] ?>",
						"location": {
							"@type": "Place",
							"name": "<?= htmlspecialchars($event[languageSwitcher("location")]) ?>"
						},
						"organizer": {
							"@type": "Organization",
							"name": "Volunteer Art Programs"
						},
						"url": "/events/<?= $event['id'] ?>"
					}
					<?= $index < count($events) - 1 ? ',' : '' ?>
				<?php endforeach ?>
			]
		}
	</script>
<?php endif ?>

<!-- SEO Structured Data for Service -->
<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "Service",
		"name": "<?= CONTENT["aboutUs"]["title"][$lang] ?? 'Volunteer Art Programs' ?>",
		"description": "<?= htmlspecialchars(strip_tags(CONTENT["aboutUs"]["description"][1][$lang] ?? '')) ?>",
		"provider": {
			"@type": "Organization",
			"name": "Volunteer Art Programs"
		},
		"serviceType": "<?= $lang === 'Hu' ? 'Művészeti önkéntes programok' : ($lang === 'En' ? 'Art volunteer programs' : 'Programas de voluntariado artístico') ?>",
		"areaServed": {
			"@type": "Country",
			"name": "Hungary"
		}
	}
</script>