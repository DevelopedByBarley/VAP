<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$user = $params["user"] ?? null;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <?php if (strpos($_SERVER['REQUEST_URI'], '/admin') === false || !isset($_SESSION["adminId"])) : ?>
                <nav class="navbar navbar-expand-xl navbar-light border-bottom fixed-top" style="background-color: white; max-width: 2300px; margin: 0 auto;" id="public-navbar">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/"><img src="/public/assets/icons/logo.png" style="height: 50px; width: 100px;" /></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 d-flex align-items-center justify-content-center">
                                <li class="nav-item m-1 mt-3">

                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#about-us' : '#about-us' ?>">
                                        <?= NAVBAR["aboutMe"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">

                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#latest-events' : '#latest-events' ?>">
                                        <?= NAVBAR["events"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">

                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#gallery' : '#gallery' ?>">
                                        <?= NAVBAR["gallery"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#volunteers' : '#volunteers' ?>">
                                        <?= NAVBAR["VoluntaryReports"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#sup_partners' : '#sup_partners' ?>">
                                        <?= NAVBAR["partners"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>

                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="<?php echo $_SERVER["REQUEST_URI"] !== "/" ?  '/#faq' : '#faq' ?>">
                                        <?= NAVBAR["faq"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <a class="navigation-link" href="#footer">
                                        <?= NAVBAR["contact"][$lang] ?? 'HIBA' ?>
                                    </a>
                                </li>
                                <li class="nav-item m-1 mt-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle navigation-link" type="button" id="language-dropdown" data-bs-toggle="dropdown" aria-expanded="false">

                                            <?php if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] === "Hu") : ?>
                                                <span>Hu</span>
                                            <?php elseif (isset($_COOKIE["lang"]) && $_COOKIE["lang"] === "En") : ?>
                                                <span>En</span>
                                            <?php else : ?>
                                                <span>Sp</span>
                                            <?php endif ?>

                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="language-dropdown">
                                            <li>
                                                <a class="dropdown-item text-center" href="/language/Hu">
                                                    Hu
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-center" href="/language/En">
                                                    En
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
                                        <?= BUTTONS["registration"][$lang] ?? 'Regisztráció' ?>
                                    </a>
                                    <a href="/login" class="btn text-light m-1" id="user-login-button">
                                        <?= BUTTONS["login"][$lang] ?? 'Bejelentkezés' ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="text-center">
                                    <div class="btn-group dropstart" id="profile-dropdown">
                                        <button type="button" class="btn dropdown-toggle p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/user/dashboard"><?= NAVBAR["profile"]["profile"][$lang] ?? 'Pofil' ?></a></li>
                                            <li><a class="dropdown-item" href="/user/settings"><?= NAVBAR["profile"]["profile_settings"][$lang] ?? 'Profil szerkesztése' ?></a></li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li><a class="dropdown-item" href="/user/logout"><?= BUTTONS["logout"][$lang] ?? 'Kijelentkezés' ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    <?php endif ?>
                    </div>
        </div>
        </nav>
    <?php else : ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">

                <div class="navbar-brand">

                    <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
                        <i style="font-size: 1.2rem;" class="bi bi-list"></i>
                    </button>

                </div>
                <div>
                    <span class="navbar-text">
                        <a href="/admin/export-all" target='_blank' class="btn btn-success text-light">Regisztrációk exportálása</a>
                        <!-- <a href="/admin/patch-notes" target='_blank' class="btn btn-primary text-light">Fejlesztések</a> -->
                        <a href="/admin/logout" class="btn btn-danger text-light">Kijelentkezés</a>
                    </span>
                </div>

            </div>
        </nav>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
            <div class="offcanvas-header">
                <div class="offcanvas-title" id="offcanvasWithBackdropLabel">
                    <a href="/admin" class="border p-2 px-4 rounded rounded-pill bg-info text-decoration-none text-light mt-3"> <?= $params["admin"]["name"] ?></a>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-group">
                    <a href="/admin/dashboard" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Vezérlőpult</li>
                    </a>
                    <a href="/admin/registrations" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Regisztrációk</li>
                    </a>
                    <a href="/admin/events" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Események</li>
                    </a>
                    <a href="/admin/volunteers" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Önkénteseink voltak</li>
                    </a>
                    <a href="/admin/gallery" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Galéria</li>
                    </a>
                    <a href="/admin/partners" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Partnerek</li>
                    </a>
                    <a href="#" class="nav-link">
                        <li class="list-group-item bg-danger text-light">Blog</li>
                    </a>
                    <a href="/admin/questions" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Gyakori kérdések</li>
                    </a>
                    <a href="/admin/documents" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Hasznos anyagok</li>
                    </a>
                    <a href="/admin/links" class="nav-link">
                        <li class="list-group-item bg-primary text-light">Hasznos linkek</li>
                    </a>
                </ul>
            </div>
        </div>
    <?php endif ?>
    </div>
</div>
</div>