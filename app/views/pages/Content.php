<?php
if (!isset($_COOKIE["lang"])) {
    include 'app/views/components/LanguageModal.php';
}
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

$volunteers = $params["volunteers"];
$volunteerDescription = "descriptionIn" . $_COOKIE["lang"];

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
                        <div class="card text-light volunteer-card bg-dark" style="width: 100%;">
                            <img src="/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>" class="card-img-top volunteer-profile-image" alt="...">
                            <div class="card-body volunteer-card-body">
                                <p class="card-text"><?= $volunteer[$volunteerDescription]  ?></p>
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

</div>