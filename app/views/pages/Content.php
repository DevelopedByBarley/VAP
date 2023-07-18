<?php
if (!isset($_COOKIE["lang"])) {
    include 'app/views/components/LanguageModal.php';
}
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

$volunteers = $params["volunteers"];
$descriptionInLang = $params["descriptionInLang"];
$questions = $params["questions"];
$partners = $params["partners"];
$questionInLang = $params["questionInLang"];
$answerInLang = $params["answerInLang"];
$nameInLang = $params["nameInLang"];
$documents = $params["documents"];
$links = $params["links"];
?>



<div class="container-fluid" disabled>
    <div class="row" id="page-header">
        <div class="col-12 col-lg-6" style="min-height: 30vh;" id="secondary-header-nav">
            <div class="text-center">
                <img src="/public/assets/icons/VAP.png" style="height: 100px; width: 180px;" />
            </div>
            <div class="text-center mb-4 ">
                <a class="btn btn-lg text-light registration-button" href="/user/registration">
                    <?= $langs["components"]["navbar"]["registrationBtn"][$lang] ?? 'Regisztráció' ?>
                </a>
            </div>
            <div id="secondary-header-list">
                <a href="#about-me" class="nav-link mt-2">
                    <?= $langs["components"]["navbar"]["aboutMe"][$lang] ?? 'Rólunk' ?>
                </a>
                <a href="" class="nav-link mt-2">
                    <?= $langs["components"]["navbar"]["VoluntaryReports"][$lang] ?? 'Önkéntes beszámolók' ?>
                </a>
                <a href="" class="nav-link mt-2">
                    <?= $langs["components"]["navbar"]["edu"][$lang] ?? 'Edu' ?>
                </a>
                <a href="" class="nav-link mt-2">
                    <?= $langs["components"]["navbar"]["partners"][$lang] ?? 'Partner Oldalak' ?>
                </a>
                <a href="" class="nav-link mt-2">
                    <?= $langs["components"]["navbar"]["blog"][$lang] ?? 'Blog' ?>
                </a>
                <a href="" class="nav-link mt-2">
                    <?= $langs["components"]["navbar"]["contact"][$lang] ?? 'Kapcsolat' ?>
                </a>
            </div>
        </div>
        <div id="header-image" class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center" style="min-height: 100vh;"></div>
    </div>
    <div class="row mt-5" id="about-us">
        <div class="col-xs-12 col-lg-7 order-lg-2 d-flex align-items-center justify-content-center flex-column text-right mt-5 mb-5">
            <h1> <?= $langs["content"]["aboutUs"]["title"][$lang] ?? 'Kapcsolat' ?></h1>
            <hr class="line mt-1 mb-5">
            <p id="about-me-dc">
                <?= $langs["content"]["aboutUs"]["description"][$lang] ?? 'Kapcsolat' ?>
            </p>
        </div>
        <div class="col-xs-12 col-lg-5 order-lg-1">
            <div id="about-me-image" style="min-height: 70vh;"></div>
        </div>
    </div>
    <div class="row" id="volunteers">
        <div class="col-xs-12 col-lg-8">
            <div class="row bg-dark d-flex align-items-center justify-content-center" style="min-height: 60vh">
                <h1 class="text-center display-4 text-light mt-5 mb-5"><?= $langs["content"]["volunteers"]["title"][$lang] ?? 'Önkénteseink voltak' ?></h1>
                <?php foreach ($volunteers as $volunteer) : ?>
                    <div class="col-xs-12 col-sm-5 col-lg-4 d-flex align-items-center justify-content-center">
                        <div class="card text-light volunteer-card bg-dark" style="width: 21rem;">
                            <img src="/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>" class="card-img-top volunteer-profile-image" alt="...">
                            <div class="card-body volunteer-card-body">
                                <p class="card-text"><?= $volunteer[$descriptionInLang]  ?></p>
                                <i><?= $volunteer["name"] ?></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4" id="volunteers-image" style="min-height: 60vh">

        </div>
    </div>

    <div class="row mt-5" id="faq">
        <div class="col-xs-12 col-lg-6">
            <h1 class="display-4 text-center mt-5 mb-5"><?= $langs["faq"][$lang] ?? 'Kapcsolat' ?></h1>
            <div class="accordion mt-5 mb-5" id="accordionExample">
                <?php foreach ($questions as $index => $question) : ?>
                    <div class="accordion-item mt-2">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $question["q_id"] ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?= $question[$questionInLang] ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $question["q_id"] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?= $question[$answerInLang] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div id="faq-image" class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center" style="min-height: 80vh;"></div>
    </div>
    <div class="row" id="partners">
        <div class="col-xs-12">
            <h1 class="display-4 text-center mt-5 mb-5"><?= $langs["partners"]["title"][$lang] ?? 'Kapcsolat' ?></h1>
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
                                    <p class="card-text"><?= $partner[$descriptionInLang] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    <?php endif; ?>
                <?php endforeach ?>
                <div class="text-center">
                    <a href="#" class="btn btn-outline-primary mt-5"><?= $langs["partners"]["partner-btn"][$lang] ?? 'Kapcsolat' ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="edu">
        <h1 class="text-center display-4 mt-5 mb-5"><?= $langs["edu"]["title"][$lang] ?? 'Kapcsolat' ?></h1>
        <div class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center flex-column">
            <h1 class="text-center display-4 mt-5 mb-5"><?= $langs["edu"]["useful_documents"][$lang] ?? 'Kapcsolat' ?></h1>
            <?php foreach ($documents as $index => $document) : ?>
                <p><a class="link-offset-2 link-underline link-underline-opacity-10" href="/public/assets/uploads/documents/<?= $document["fileName"] ?>"><?= $document[$nameInLang] ?></a></p>
            <?php endforeach ?>
        </div>
        <div class="col-xs-12 col-lg-6 d-flex align-items-center justify-content-center flex-column">
            <h1 class="text-center display-4 mt-5 mb-5"><?= $langs["edu"]["useful_links"][$lang] ?? 'Kapcsolat' ?></h1>
            <?php foreach ($links as $index => $link) : ?>
                <p><a class="link-offset-2 link-underline link-underline-opacity-10" href="<?= $link["link"] ?>" target="_blank"    ><?= $link[$nameInLang] ?></a></p>
            <?php endforeach ?>
        </div>
    </div>
</div>

</div>