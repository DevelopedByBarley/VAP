<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <?php if (strpos($_SERVER['REQUEST_URI'], '/admin') === false || !isset($_SESSION["adminId"])) : ?>
                <nav class="navbar navbar-expand-lg navbar-light border-bottom fixed-top" style="background-color: white; max-width: 2300px; margin: 0 auto;" id="public-navbar">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><img src="/public/assets/icons/VAP.png" style="height: 50px; width: 100px;" /></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 d-flex align-items-center justify-content-center">
                                <li class="nav-item m-1 mt-3">

                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#about-us' : '#about-us' ?>">
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

                                            <?php if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] === "Hu") : ?>
                                                <img src="/public/assets/icons/hu.png" style="height: 30px; width: 30px;" />
                                            <?php elseif (isset($_COOKIE["lang"]) &&$_COOKIE["lang"] === "En") : ?>
                                                <img src="/public/assets/icons/en.png" style="height: 30px; width: 30px;" />
                                            <?php else : ?>
                                                <img src="/public/assets/icons/en.png" style="height: 30px; width: 30px;" />
                                            <?php endif ?>

                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="language-dropdown">
                                            <li>
                                                <a class="dropdown-item text-center" href="/language/Hu">
                                                    <img src="/public/assets/icons/hu.png" style="height: 30px; width: 30px;" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-center" href="/language/En">
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
                            <?php if (!isset($_SESSION["userId"])) : ?>
                                <div class="navbar-text text-center mt-3 d-flex align-items-center justify-content-center">
                                    <a href="/user/registration" class="btn text-light m-1" id="user-registration-button">
                                        <?= $langs["components"]["navbar"]["registrationBtn"][$lang] ?? 'Regisztráció' ?>
                                    </a>
                                    <a href="/login" class="btn text-light m-1" id="user-login-button">
                                        <?= $langs["components"]["navbar"]["loginBtn"][$lang] ?? 'Bejelentkezés' ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <?php if ($_SERVER['REQUEST_URI'] !== '/user/dashboard') : ?>
                                    <div class="text-center">
                                        <a class="m-1" href="/user/dashboard">
                                            <img src="/public/assets/icons/user.png" style="height: 40px; width: 40px;" />
                                        </a>
                                    </div>
                                <?php endif ?>
                                <div class="text-center">
                                    <a href="/user/logout" class="m-1 btn btn-danger text-light" id="user-logout-button">
                                        <?= $langs["components"]["navbar"]["logoutBtn"][$lang] ?? 'Önkéntes beszámolók' ?>
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </nav>
            <?php else : ?>
                <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                    <div class="container-fluid">
                        <div class="navbar-brand"><button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i style="font-size: 1.2rem;" class="bi bi-list"></i></button></div>
                        <span class="navbar-text">
                            <a href="/admin/logout" class="btn btn-danger text-light">Kijelentkezés</a>
                        </span>
                    </div>
                </nav>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel"><?= $params["admin"]["name"] ?></h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-group">
                            <a href="#" class="nav-link">
                                <li class="list-group-item bg-danger text-light">Regisztrációk</li>
                            </a>
                            <a href="/admin/volunteers" class="nav-link">
                                <li class="list-group-item bg-primary text-light">Önkéntesek</li>
                            </a>
                            <a href="/admin/partners" class="nav-link">
                                <li class="list-group-item bg-primary text-light">Partnerek</li>
                            </a>
                            <a href="#" class="nav-link">
                                <li class="list-group-item bg-danger text-light">EDU</li>
                            </a>
                            <a href="#" class="nav-link">
                                <li class="list-group-item bg-danger text-light">Blog</li>
                            </a>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>