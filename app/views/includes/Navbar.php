<?php
require 'config/lang/lang.php';
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <?php if ($_SERVER['REQUEST_URI'] !== '/administrator/dashboard') : ?>
                <nav class="navbar navbar-expand-lg navbar-light border-bottom fixed-top" style="background-color: white; max-width: 2300px; margin: 0 auto;" id="public-navbar">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><img src="public/assets/icons/VAP.png" style="height: 50px; width: 100px;" /></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 d-flex align-items-center justify-content-center">
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#about-me">
                                        <?= $langs["components"]["navbar"]["aboutMe"][$lang] ?? 'Rólunk' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#">
                                        <?= $langs["components"]["navbar"]["VoluntaryReports"][$lang] ?? 'Önkéntes beszámolók' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#">
                                        <?= $langs["components"]["navbar"]["edu"][$lang] ?? 'Edu' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#">
                                        <?= $langs["components"]["navbar"]["partners"][$lang] ?? 'Partner Oldalak' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#">
                                        <?= $langs["components"]["navbar"]["blog"][$lang] ?? 'Blog' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#">
                                        <?= $langs["components"]["navbar"]["contact"][$lang] ?? 'Kapcsolat' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle navigation-link" type="button" id="language-dropdown" data-bs-toggle="dropdown" aria-expanded="false">

                                            <?php if ($_COOKIE["lang"] === "hu") : ?>
                                                <img src="/public/assets/icons/hu.png" style="height: 30px; width: 30px;" />
                                            <?php elseif ($_COOKIE["lang"] === "en") : ?>
                                                <img src="/public/assets/icons/en.png" style="height: 30px; width: 30px;" />
                                            <?php else : ?>
                                                <img src="/public/assets/icons/en.png" style="height: 30px; width: 30px;" />
                                            <?php endif ?>

                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="language-dropdown">
                                            <li>
                                                <a class="dropdown-item text-center" href="/language/hu">
                                                    <img src="/public/assets/icons/hu.png" style="height: 30px; width: 30px;" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-center" href="/language/en">
                                                    <img src="/public/assets/icons/en.png" style="height: 30px; width: 30px;" />
                                                </a>
                                            </li>
                                            <!--
                                            <li>
                                                <a class="dropdown-item disabled bg-secondary" href="/language/sp">
                                                    <img src="/public/assets/icons/sp.png" style="height: 30px; width: 30px;" />
                                                </a>
                                            </li>
                                        -->
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                            <div class="navbar-text text-center mt-3">
                                <a href="/user/registration" class="btn text-light" id="user-registration-button">Regisztráció</a>
                            </div>
                        </div>
                    </div>
                </nav>
            <?php else : ?>
                <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                    <div class="container-fluid">
                        <div class="navbar-brand"><button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">Menu</button></div>
                        <span class="navbar-text">
                            <a href="/administrator/logout" class="btn btn-danger text-light">Kijelentkezés</a>
                        </span>
                    </div>
                </nav>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Menu</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-group">
                            <li class="list-group-item">An item</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                            <li class="list-group-item">Partnerek</li>
                            <li class="list-group-item">And a fifth one</li>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>