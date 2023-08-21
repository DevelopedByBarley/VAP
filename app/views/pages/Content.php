<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$volunteers = $params["volunteers"];
$questions = $params["questions"];
$partners = $params["partners"];
$documents = $params["documents"];
$links = $params["links"];
$latestEvent = $params["latestEvent"];
?>



<div class="container-fluid" style="margin-top: 100px;">
	<div class="row mt-5" id="about-us">
		<div class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center flex-column mt-5 mb-5" id="about-us-content">
			<h1 class="display-5"> <?= CONTENT["aboutUs"]["title"][$lang] ?? '' ?></h1>
			<hr class="line mt-1 mb-5">
			<p id="about-me-dc">
				<?= CONTENT["aboutUs"]["description"][$lang] ?? '' ?>
			</p>
		</div>
		<div class="col-xs-12 col-lg-6 order-lg-1">
			<div id="about-me-image" style="min-height: 70vh;"></div>
		</div>
	</div>
	<div class="row mt-3 mb-5" id="intro">
		<div class="col-xs-12 text-center mt-5 mb-5 d-flex align-items-center justify-content-center flex-column" id="recommend">
			<div class="p-4">
				<h1 class="display-5 mb-3">Kiknek ajánljuk?</h1>
				<p style="width: 70%; margin: 0 auto;" class="mb-5">
					Lorem ipsum dolor sit amet consectetur adipisicing elit. In reprehenderit aspernatur dolorem!
					Ipsum fuga quam molestiae beatae delectus, minus debitis amet maiores animi possimus recusandae eos perferendis inventore cum cumque.
					Lorem ipsum dolor sit amet consectetur, adipisicing elit.
					Accusantium non id sapiente molestiae error! Voluptatem animi voluptate ut minus.
					Aliquam nostrum inventore, voluptates animi blanditiis necessitatibus veniam harum! Tempora, ipsam!
					Lorem ipsum dolor sit amet consectetur adipisicing elit. In reprehenderit aspernatur dolorem!
					Ipsum fuga quam molestiae beatae delectus, minus debitis amet maiores animi possimus recusandae eos perferendis inventore cum cumque.
					Lorem ipsum dolor sit amet consectetur, adipisicing elit.
					Accusantium non id sapiente molestiae error! Voluptatem animi voluptate ut minus.
					Aliquam nostrum inventore, voluptates animi blanditiis necessitatibus veniam harum! Tempora, ipsam!
				</p>
			</div>
		</div>
	</div>
	<div class="row" id="volunteers">
		<div class="col-xs-12 col-lg-8">
			<div class="row bg-dark d-flex align-items-center justify-content-center" style="min-height: 60vh">
				<h1 class="text-center display-4 text-light mt-5 mb-5"><?= CONTENT["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?></h1>
				<?php foreach ($volunteers as $volunteer) : ?>
					<div class="col-xs-12 col-sm-5 col-lg-4 d-flex align-items-center justify-content-center">
						<div class="card text-light volunteer-card bg-dark" style="width: 21rem;">
							<img src="/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>" class="card-img-top volunteer-profile-image" alt="...">
							<div class="card-body volunteer-card-body">
								<p class="card-text"><?= $volunteer[languageSwitcher("description")]  ?></p>
								<i><?= $volunteer["name"] ?></i>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<div class="col-xs-12 col-lg-4" id="volunteers-image" style="min-height: 60vh"></div>
	</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<h1>Következő eseményünk</h1>
			</div>
			<div class="col-xs-12 col-sm-6">
				<div class="card" style="width: 18rem;">
					<img src="/public/assets/uploads/images/events/<?= $latestEvent["fileName"] ?>" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title"><?= $latestEvent[languageSwitcher("name")] ?></h5>
						<p class="card-text"><b><?= date('Y/m/d', $latestEvent["createdAt"]) ?></b></p>
						<p class="card-text"><?= $latestEvent[languageSwitcher("description")] ?></p>
						<a href="/event/register/<?= $latestEvent["eventId"] ?>" class="btn btn-primary">Regisztráció</a>
					</div>
				</div>
			</div>
		</div>


	<div class="row mt-5" id="faq">
		<div class="col-xs-12">
			<h1 class="display-4 text-center mt-5 mb-5"><?= CONTENT["faq"][$lang] ?? '' ?></h1>
			<div class="accordion mt-5 mb-5" id="questionAccordion">
				<?php foreach ($questions as $index => $question) : ?>
					<div class="accordion-item mt-2">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $question["q_id"] ?>" aria-expanded="true" aria-controls="collapseOne">
								<?= $question[languageSwitcher("question")] ?>
							</button>
						</h2>
						<div id="collapse<?= $question["q_id"] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#questionAccordion">
							<div class="accordion-body">
								<?= $question[languageSwitcher("answer")] ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div class="row" id="partners">
		<div class="col-xs-12">
			<h1 class="display-4 text-center mt-5 mb-5"><?= CONTENT["partners"]["title"][$lang] ?? '' ?></h1>
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
			<h1 class="text-center display-4 mt-5 mb-5"><?= CONTENT["edu"]["useful_documents"][$lang] ?? '' ?></h1>
			<?php foreach ($documents as $index => $document) : ?>
				<p><a class="link-offset-2 link-underline link-underline-opacity-10" href="/public/assets/uploads/documents/admin/<?= $document["fileName"] ?>"><?= $document[languageSwitcher("name")] ?></a></p>
			<?php endforeach ?>
		</div>
		<div class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center flex-column">
			<h1 class="text-center display-4 mt-5 mb-5"><?= CONTENT["edu"]["useful_links"][$lang] ?? '' ?></h1>
			<?php foreach ($links as $index => $link) : ?>
				<p><a class="link-offset-2 link-underline link-underline-opacity-10" href="<?= $link["link"] ?>" target="_blank"><?= $link[languageSwitcher("name")] ?></a></p>
			<?php endforeach ?>
		</div>
	</div>
</div>

</div>