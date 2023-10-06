<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$events = $params["events"];

?>


<div class="d-flex align-items-center justify-content-center" style="min-height: 95vh;">
  <div class="container p-3" style="min-height: 75vh">
    <?php if (count($events) === 0) : ?>
      <div class="row">
        <h1 class="text-center mb-5">Jelenleg nincs egyetlen eseményünk sem!</h1>
      </div>
    <?php else : ?>
      <div class="row">
        <h1 class="text-center mb-5">További eseményeink</h1>
        <?php foreach ($events as $event) : ?>
          <div class="col-12 ">
            <div class="card-group event-card mb-4">
              <a class="w-100" href="/event/<?= $event["eventId"] ?>" style="text-decoration: none;">
                <div class="card mb-0">
                  <div class="card-body py-1">
                    <div class="row">
                      <div class="col-3 sc-color  col-sm-3 d-flex align-items-center justify-content-center flex-column">

                        <div class="display-4 text-light">
                          <?= date("m/d", strtotime($event["date"])) ?>
                        </div>
                      </div>
                      <div class="col-9 col-sm-9">
                        <div class="d-flex flex-column">
                          <h3 class="card-title text-uppercase mt-0 pr-color p-2 text-light">
                            <strong><?= $event[languageSwitcher("name")] ?></strong>
                          </h3>
                          <div class="card-text text-dark">
                            <?= $event[languageSwitcher("description")] ?>
                          </div>
                          <div class="mt-3">
                            <ul class="list-inline mt-auto">
                              <li class="list-inline-item"> <strong>Published By :</strong></li>
                              <li class="list-inline-item"><img src="/public/assets/icons/bear.png" style="height: 30px; width: 30px;" /> Admin name</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

            </div>

          <?php endforeach ?>
          </div>
        <?php endif ?>
      </div>
  </div>