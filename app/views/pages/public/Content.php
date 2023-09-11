<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$volunteers = $params["volunteers"];
$partners = $params["partners"];
$documents = $params["documents"];
$links = $params["links"];
$latestEvent = $params["latestEvent"];

?>


<div class="container-fluid">
	<header id="header">
		<div class="row">
			<div class="col-12 col-lg-8 d-flex align-items-center justify-content-center flex-column" id="header-intro">
				<h1 class="text-center mb-3"><span class="letters">V</span>olunteer <span class="letters">A</span>rt <span class="letters">P</span>rograms</h1>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptas nulla asperiores esse? Molestiae sapiente, quidem deserunt fuga</p>
				<a href="/user/registration" class="btn registration-btn btn text-light">Regisztráció</a>

				<a href="#about-us"><i class="bi bi-arrow-down-circle" id="go-down"></i></a>
			</div>
			<div class="col-12 col-lg-4 d-flex align-items-center justify-content-center flex-column" id="header-image"></div>
		</div>

		<div class="row mt-5 bg-dark text-light" id="about-us">
			<div class="col-12 d-flex align-items-center justify-content-center flex-column mt-5 mb-5 p-3" id="about-us-content">
				<h1 class="reveal"> <?= CONTENT["aboutUs"]["title"][$lang] ?? '' ?></h1>
				<hr class="line mt-1 mb-5 reveal">
				<p id="about-me-dc" class="reveal">
					<?= CONTENT["aboutUs"]["description"][$lang] ?? '' ?>
				</p>
			</div>
		</div>

		<div class="row p-3 d-flex flex-column-reverse flex-lg-row align-items-center justify-content-center" id="recommendation">
			<div class="col-12 col-lg-4 reveal" id="recommendation-content">
				<h6 class="text-light mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
				<h6 class="text-light mt-2">Suspendisse ornare odio posuere, egestas justo sit amet, malesuada arcu.</h6>
				<h6 class="text-light mt-2">Ut tempus nulla sed maximus viverra asdassd asd.</h6>
				<h6 class="text-light mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
				<h6 class="text-light mt-2">Suspendisse ornare odio posuere, egestas justo sit amet, malesuada arcu.</h6>
				<h6 class="text-light mt-2">Ut tempus nulla sed maximus viverra.</h6>
			</div>
			<div class="col-12 col-lg-4 d-flex align-items-center justify-content-center reveal">
				<h1 class="text-light text-center mb-3">Kiknek ajánljuk a programot?</h1>
			</div>
		</div>
		<div class="row p-3" id="advantages">
			<div class="col-12 col-lg-6 d-flex align-items-center justify-content-center reveal">
				<h1 class="text-light mb-4">Jellemző feladatok</h1>
			</div>
			<div class="col-12 col-lg-6 reveal d-flex justify-content-center flex-column">
				<h6 class="text-light mt-2">Kiállítói és galéria asszisztens</h6>
				<h6 class="text-light mt-2">Ügyintéző, rendezvényszervező asszisztens</h6>
				<h6 class="text-light mt-2">Program koordinátor</h6>
				<h6 class="text-light mt-2">Információs pultban munkatárs</h6>
				<h6 class="text-light mt-2">Építész, logisztika, raktár felügyelet</h6>
				<h6 class="text-light mt-2">Hostess feladatok (vendégek kísérésre, VIP események felügyelete, vendégregisztráció)</h6>
				<h6 class="text-light mt-2">Esemény előtti adminisztrációs feladatok (pl: információ gyűjtés, adatbázis tisztítás, szöveg ellenőrzés stb.)</h6>
			</div>
		</div>

</div>


<div class="row reveal mt-5 p-5 r-border" id="volunteers">
	<div class="col-xs-12">
		<div id="volunteers-header" class="mb-5 bg-dark text-light w-100 p-5 r-border shadow">
			<h1 class="text-center mt-5 mb-4"><?= CONTENT["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?></h1>
			<p class="text-center" style="width: 70%; margin: 0 auto;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit, error amet numquam iure provident voluptate esse quasi, veritatis totam voluptas nostrum quisquam eum porro a pariatur veniam.</p>
		</div>
		<div class="row d-flex align-items-center justify-content-center" id="v-cards" style="min-height: 60vh">
			<?php foreach ($volunteers as $volunteer) : ?>
				<div class="col-xs-12 col-sm-6 col-lg-4 d-flex align-items-center justify-content-center mt-2">
					<div class="card volunteer-card r-border" style="width: 25rem;">
						<div style="background: url(/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>) center center/cover" class="card-img-top volunteer-profile-image"> </div>
						<div class="card-body volunteer-card-body mt-3">
							<p class="card-text"><i class="bi bi-quote m-2" style="font-size: 1.2rem;"></i><?= $volunteer[languageSwitcher("description")]  ?></p>
							<i><?= $volunteer["name"] ?></i>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>

<div class="row d-flex align-items-center justify-content-center" id="typical-tasks">
	<div class="col-12 mb-5 reveal">
		<h1 class="text-center mb-3">Önkéntesség előnyei</h1>
		<p class="text-center mb-5">Milyen hasznos tudásra és előnyökre tehetsz szert a VAP programból? </p>
	</div>
	<div class="row d-flex align-items-center justify-content-center">
		<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
			<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
				<div class="card-header text-center">
					<img src="/public/assets/icons/performance.png" style="width: 80px;" alt="">
				</div>
				<div class="card-body">
					<h5 class="card-title">Light card title</h5>
					<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
			<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
				<div class="card-header text-center">
					<img src="/public/assets/icons/performance.png" style="width: 80px;" alt="">
				</div>
				<div class="card-body">
					<h5 class="card-title">Light card title</h5>
					<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
			<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
				<div class="card-header text-center">
					<img src="/public/assets/icons/performance.png" style="width: 80px;" alt="">
				</div>
				<div class="card-body">
					<h5 class="card-title">Light card title</h5>
					<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
			<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
				<div class="card-header text-center">
					<img src="/public/assets/icons/performance.png" style="width: 80px;" alt="">
				</div>
				<div class="card-body">
					<h5 class="card-title">Light card title</h5>
					<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
			<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
				<div class="card-header text-center">
					<img src="/public/assets/icons/performance.png" style="width: 80px;" alt="">
				</div>
				<div class="card-body">
					<h5 class="card-title">Light card title</h5>
					<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4 col-sm-6 d-flex align-items-center justify-content-center reveal">
			<div class="card text-dark bg-light mb-5 shadow" style="max-width: 18rem;">
				<div class="card-header text-center">
					<img src="/public/assets/icons/performance.png" style="width: 80px;" alt="">
				</div>
				<div class="card-body">
					<h5 class="card-title">Light card title</h5>
					<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				</div>
			</div>
		</div>
	</div>
</div>
</header>

<div id="parallax-wrapper" class="mb-5">
	<div class="mt-5 mb-5" id="parallax"></div>
	<div id="parallax-filter"></div>
</div>



<div class="row	mt-5 bg-light text-dark p-3 shadow" id="latest-event">
	<div class="col-xs-12 col-sm-6 d-flex align-items-center justify-content-center flex-column reveal">
		<h1 class="mt-5 mb-2">Következő eseményünk</h1>
		<p class="p-2 mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores ducimus, distinctio cumque doloremque animi id perferendis error aut est fugit esse architecto maxime! Non a iure expedita aut id totam.</p>
	</div>
	<div class="col-xs-12 col-sm-6 d-flex align-items-center justify-content-center text-dark reveal">
		<div class="card" style="width: 20rem;">
			<img src="/public/assets/uploads/images/events/<?= $latestEvent["fileName"] ?>" class="card-img-top" style="width: 100%" alt="...">
			<div class="card-body">
				<h3><?= $latestEvent[languageSwitcher("name")] ?></h3>
				<p class="card-text"><b><?= date('Y/m/d', $latestEvent["createdAt"]) ?></b></p>
				<p class="card-text"><?= $latestEvent[languageSwitcher("description")] ?></p>
				<a href="/event/<?= $latestEvent["eventId"] ?>" class="btn btn-primary">Megtekintés</a>

			</div>
		</div>
	</div>
</div>





















<div class="row mt-5 reveal" id="partners">
	<div class="col-xs-12">
		<h1 class="text-center mt-5 mb-5"><?= CONTENT["partners"]["title"][$lang] ?? '' ?></h1>
		<div class="row mb-5">
			<?php $counter = 0; ?>
			<?php foreach ($partners as $index => $partner) : ?>
				<?php if ($counter < 4) : ?>
					<div class="col-xs-12 col-sm-6 col-lg-3 mt-5">
						<div class="card partner-card" style="width: 23rem; border: none">
							<div class="d-flex align-items-center justify-content-center">
								<img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" style="height: 150px; width: 150px; border-radius: 100%;" class="card-img-top" alt="...">
							</div>
							<div class="card-body">
								<h5 class="card-title"><?= $partner["name"] ?></h5>
								<p class="card-text"><?= $partner[languageSwitcher("description")] ?></p>
							</div>
						</div>
					</div>
					<?php $counter++; ?>
				<?php endif; ?>
			<?php endforeach ?>
			<div class="text-center">
				<a href="#" class="btn btn-outline-primary mt-5"><?= CONTENT["partners"]["partner-btn"][$lang] ?? '' ?></a>
			</div>
		</div>
	</div>
</div>
<div class="row" id="edu">
	<div class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center flex-column">
		<h1 class="text-center mt-5 mb-5"><?= CONTENT["edu"]["useful_documents"][$lang] ?? '' ?></h1>
		<?php foreach ($documents as $index => $document) : ?>
			<p><a class="link-offset-2 link-underline link-underline-opacity-10" href="/public/assets/uploads/documents/admin/<?= $document["fileName"] ?>"><?= $document[languageSwitcher("name")] ?></a></p>
		<?php endforeach ?>
	</div>
	<div class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center flex-column">
		<h1 class="text-center mt-5 mb-5"><?= CONTENT["edu"]["useful_links"][$lang] ?? '' ?></h1>
		<?php foreach ($links as $index => $link) : ?>
			<p><a class="link-offset-2 link-underline link-underline-opacity-10" href="<?= $link["link"] ?>" target="_blank"><?= $link[languageSwitcher("name")] ?></a></p>
		<?php endforeach ?>
	</div>
</div>
</div>

</div>