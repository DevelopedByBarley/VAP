<?php $currentRoute = $_SERVER['REQUEST_URI'];
$isAdminRoute = (strpos($currentRoute, 'admin') !== false);
$documents = $params['documents'] ?? [];

?>
<?php if (!isset($_SESSION['adminId']) || !$isAdminRoute): ?>
    <div class="row reveal bg-danger" style="margin-top: 150px;" id="footer">
        <footer class="text-center text-lg-start text-white sc-color d-flex align-items-center justify-content-center">
            <!-- Grid container -->
            <div class="container-fluid p-4 pb-0">
                <!-- Section: Links -->
                <section>
                    <!--Grid row-->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                            <h3 class="text-uppercase font-weight-bold ">
                                Volunteer Art Programs
                            </h3>
                            <a href="https://www.facebook.com/profile.php?id=61565061561678" target="_blank">
                                <img src="/public/assets/icons/FB.png" alt="" style="width: 65px; height: 65px;">
                            </a>
                            <a href=" https://www.instagram.com/volunteer_art_programs" target="_blank">
                                <img src="/public/assets/icons/insta.png" alt="" style="width: 65px; height: 65px;  position: relative; right: 15px; top: 3px;">
                            </a>
                        </div>
                        <!-- Grid column -->

                        <hr class="w-100 clearfix d-md-none" />

                        <!-- Grid column -->
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                            <p class="text-uppercase mb-4 fw-bold ">
                                <?= CONTENT["footer"]["docs"][$lang] ?? 'HIBA' ?> </p>
                            </p>
                            <?php foreach ($documents as $index => $document) : ?>
                                <p><a class="link-offset-2 link-underline link-underline-opacity-10 text-light" href="/public/assets/uploads/documents/admin/<?= $document["fileName"] ?>" download><?= $document[languageSwitcher("name")] ?></a></p>
                            <?php endforeach ?>

                        </div>
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                            <p class="text-uppercase mb-4 fw-bold">
                                <?= CONTENT["footer"]["privacy_policy"][$lang] ?? 'HIBA' ?> </p>

                            </p>

                            <?php if ($lang === "Hu") : ?>
                                <a href="/public/files/adatkezeles.hu.docx.pdf" class="text-light">Adatkezelési tájékoztató</a>
                            <?php elseif ($lang === "Sp") : ?>
                            <?php else : ?>
                                <a href="/public/files/privacy_policy.docx.pdf" class="text-light">Privacy policy</a>
                            <?php endif ?>
                        </div>
                        <!-- Grid column -->

                        <hr class="w-100 clearfix d-md-none" />



                        <!-- Grid column -->
                        <hr class="w-100 clearfix d-md-none" />

                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                            <p><b>ArtNESZ Képzőművészeti Ügynökség Kft.</b></p>
                            <p><a class="d-block text-light" href="https://www.artnesz.hu">www.artnesz.hu</a></p>
                            <p><a class="d-block text-light" href="mailto:hello@artnesz.hu">E-mail: hello@artnesz.hu</a></p>
                            <p> <?= CONTENT["footer"]["address"][$lang] ?? 'HIBA' ?> </h6>: 2030 Érd Murányi utca 20</p>
                            <p> <?= CONTENT["footer"]["company_registration_number"][$lang] ?? 'HIBA' ?> </h6>: 13-09-197718</p>


                        </div>
                        <!-- Grid column -->
                    </div>
                    <!--Grid row-->
                    <div class="row d-flex align-items-center">
                        <!-- Grid column -->
                        <div class="col-md-6 col-lg-6 text-center text-md-start">
                            <!-- Copyright -->
                            <div class="p-3">
                                © 2025 Copyright:
                                <a class="text-white" href="<?= CURRENT_URL ?>"><?= CURRENT_URL ?></a>
                            </div>
                            <!-- Copyright -->
                        </div>
                        <div class="col-md-6 col-lg-6 text-center text-md-end">
                            <!-- Copyright -->
                            <div class="p-3">
                                Készítette:
                                <a class="text-white" href="https://max.hu/">Max & Future csapata</a>
                            </div>
                            <!-- Copyright -->
                        </div>

                    </div>
                </section>
            </div>
        </footer>
    </div>


<?php endif ?>
<!-- Grid column -->

<!-- 
                    <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                        <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="bi bi-facebook"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="bi bi-twitter"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="bi bi-messenger"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="bi bi-instagram"></i></a>
                    </div>
                    Grid column -->