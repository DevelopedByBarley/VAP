<?php
$event = $params["event"];
$dates = $params["dates"];
$tasks = $params["tasks"];
$user = $params["user"];
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$errors = $params["errors"];
$prev = $params["prev"];

$userLanguages = $prev["userLanguages"] ?? null;





?>

<div class="container-fluid">

  <div class="p-3 container" style="min-height: 100vh;">
    <?php if ($user) : ?>
      <div class="row bg-dark">
        <div class="col-12 col-sm-4 col-lg-2 d-flex align-items-end ms-sm-5 justify-content-start" style="min-height: 35vh">
          <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 200px; z-index: 1; filter: grayscale(100%)">
        </div>
        <div class="col-12 col-sm-4 col-lg-2 d-flex align-items-start justify-content-end flex-column text-light">
          <h5><?= $user["name"] ?></h5>
          <p><?= $user["address"] ?></p>
          <a href="/user/dashboard" class="btn btn-outline-light mb-3" data-mdb-ripple-color="dark" style="z-index: 1;">
            <?= SUBSCRIBE_FORM["check_profile"][$lang] ?? '' ?>
          </a>
        </div>
      </div>

      <div class="row p-sm-5">
        <div class="col-12 text-center mt-3">
          <h1 class="text-uppercase mt-5"><?= SUBSCRIBE_FORM["title"][$lang] ?? 'HIBA' ?></h1>
        </div>
        <div class="text-center mb-5">
          <small><i><?= SUBSCRIBE_FORM["message"][$lang] ?? 'HIBA' ?></i></small>
        </div>
        <div class="col-xs-12 text-start">
          <form action="/event/subscribe/<?= $event["eventId"] ?>" method="POST">
            <div class="mb-4">
              <div class="mb-3">
                <i><b><?= SUBSCRIBE_FORM["choose_time"][$lang] ?? 'HIBA' ?></b></i>
              </div>
              <div class="btn-group">
                <?php foreach ($dates as $index => $date) : ?>
                  <input type="checkbox" class="btn-check" id="date-<?= $index ?>" autocomplete="off" name="dates[]" value="<?= $date["date"] ?>">
                  <label class="btn btn-outline-dark m-1" for="date-<?= $index ?>"><?= $date["date"] ?></label><br>
                <?php endforeach ?>
              </div>
            </div>
            <div class="mb-4">
              <div class="mb-3">
                <i><b><?= SUBSCRIBE_FORM["choose_task"][$lang] ?? 'HIBA' ?></b></i>
              </div>
              <?php foreach ($tasks as $index => $task) : ?>
                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="task<?= $index ?>" value="<?= $task["task"] ?>" name="tasks[<?= $index ?>]">
                    <label class="form-check-label" id="task<?= $index ?>"><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></label>
                  </div>
                </div>
              <?php endforeach ?>
            </div>

            <div class="text-center">
              <button type="submit" class="btn secondary-btn"> <?= REGISTRATION["form"]["registrationBtn"][$lang] ?? 'HIBA' ?></button>
            </div>


          </form>
        </div>
      </div>
    <?php else : ?>




































      <form class="p-3" style="background-color: white;;" action="/event/subscribe/<?= $event["eventId"] ?>" method="POST" enctype="multipart/form-data">
        <h3 class="text-center mb-5 mt-5 text-uppercase">Regisztráció kitöltése</h3>

        <div class="row mb-4 mt-5">



          <div class="col-xs-12">
            <div class="form-outline">
              <label class="form-label required" for="name"><b><?= REGISTRATION["form"]["name"][$lang] ?? 'HIBA' ?></b></label>
              <input type="text" id="name" name="name" class="form-control <?= (!isset($errors["name"])) ? '' : 'border border-danger'  ?> <?= (!isset($errors["name"])) && isset($prev["name"]) ? 'border border-success' : ''  ?>" value="<?= $prev["name"] ?? '' ?>" required placeholder="<?= REGISTRATION["form"]["name"][$lang] ?? 'HIBA' ?>" />
              <?php if (isset($errors["name"])) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors["name"] as $error) : ?>
                    <?= $error ?>
                  <?php endforeach ?>

                </div>
              <?php endif ?>
            </div>
          </div>


          <div class="col-xs-12 col-md-6 mt-3">
            <div class="form-outline mb-4">
              <label class="form-label required" for="email"><b><?= REGISTRATION["form"]["email"][$lang] ?? 'HIBA' ?></b></label>
              <input type="email" id="email" name="email" pattern=".{11,}" class="form-control <?= (!isset($errors["email"])) ? '' : 'border border-danger'  ?> <?= (!isset($errors["email"])) && isset($prev["email"]) ? 'border border-success' : ''  ?>" required value="<?= $prev["email"] ?? '' ?>" placeholder="<?= REGISTRATION["form"]["email"][$lang] ?? 'HIBA' ?>" />

              <?php if (isset($errors["email"])) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors["email"] as $error) : ?>
                    <?= $error ?>
                  <?php endforeach ?>
                </div>
              <?php endif ?>

            </div>
          </div>


          <div class="col-xs-12 col-md-6 mt-3">
            <div class="form-outline mb-4">
              <label class="form-label required" for="city"><b><?= REGISTRATION["form"]["address"][$lang] ?? 'HIBA' ?></b></label>
              <input type="text" id="address" name="address" class="form-control <?= (!isset($errors["address"])) ? '' : 'border border-danger'  ?> <?= (!isset($errors["address"])) && isset($prev["address"]) ? 'border border-success' : ''  ?>" required value="<?= $prev["address"] ?? '' ?>" placeholder="<?= REGISTRATION["form"]["address"][$lang] ?? 'HIBA' ?>" />

              <?php if (isset($errors["address"])) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors["address"] as $error) : ?>
                    <?= $error ?>
                  <?php endforeach ?>
                </div>
              <?php endif ?>
            </div>

          </div>





          <div class="col-xs-12 col-md-6 mt-3">
            <div class="form-outline mb-4">
              <label class="form-label" for="phone"><b><?= REGISTRATION["form"]["mobile"][$lang] ?? 'HIBA' ?></b></label>
              <input type="number" id="phone" name="mobile" class="form-control <?= (!isset($errors["mobile"])) ? '' : 'border border-danger'  ?> <?= (!isset($errors["mobile"])) && isset($prev["mobile"]) ? 'border border-success' : ''  ?>" value="<?= $prev["mobile"] ?? '' ?>" placeholder="<?= REGISTRATION["form"]["mobile"][$lang] ?? 'HIBA' ?>" style="border: <?= !(isset($errors["phone"])) ? '1px solid green' : ''  ?>" />

              <?php if (isset($errors["mobile"])) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors["mobile"] as $error) : ?>
                    <?= $error ?>
                  <?php endforeach ?>
                </div>
              <?php endif ?>

            </div>
          </div>

          <div class="col-xs-12 mt-3">
            <div class="form-outline mb-4 text-center">
              <label class="form-label mb-3 required"><b><?= PROFESSIONS["title"][$lang] ?? 'HIBA' ?></b></label>
              <br>
              <?php foreach (PROFESSIONS["profession"] as $index => $profession) : ?>
                <input type="radio" class="btn-check" name="profession" id="profession_<?= $index ?>" value="<?= $profession['Hu'] ?>" <?= isset($prev) && $prev["profession"] === $profession["Hu"] ? 'checked' : '' ?> autocomplete="off" required>
                <label class="btn btn-outline-primary" for="profession_<?= $index ?>">
                  <?= $profession[$lang] ?? 'Diák vagyok' ?>
                </label>
              <?php endforeach ?>
            </div>
          </div>





          <div class="col-xs-12 mt-3">
            <div class="form-outline mb-4">
              <label class="form-label" for="school-name"><b>
                  <?= EDU_INSTITUTION[$lang] ?? 'HIBA' ?>
                </b></label>
              <input type="text" id="school-name" name="school_name" class="form-control" value="<?= $prev["school_name"] ?? '' ?>" placeholder="<?= REGISTRATION["form"]["school_name"][$lang] ?? 'HIBA' ?>""/>
        </div>
      </div>




      <div class=" col-xs-12 mt-3">
              <div class="form-outline mb-4">
                <label class="form-label required" for="programs"><b> <?= PROGRAMS["title"][$lang] ?? 'HIBA' ?></b></label>
                <?php foreach (PROGRAMS["program"] as $index => $program) : ?>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="programs" id="program-<?= $index ?>" value="<?= $index ?>" required <?= isset($prev) && PROGRAMS["program"][$prev["programs"]]["Hu"] === $program["Hu"] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="program-<?= $index ?>">
                      <?= $program[$lang] ?? '' ?>
                    </label>
                  </div>
                <?php endforeach ?>
              </div>
            </div>




            <div class="col-xs-12 mt-3" id="<?= isset($prev) ? 'user-languages' : '' ?>" <?= isset($prev) ? "data-langs='" . (isset($prev) ? json_encode($userLanguages) : null) . "'" : '' ?>>
              <div class="form-outline mb-4">
                <label class="form-check-label required" for="languages">
                  <b> <?= LANGUANGE_KNOWLEDGE["title"][$lang] ?? 'HIBA' ?></b>
                </label>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary m-3" id="lang-modal-btn">
                  <?= USER_LANGUAGES["btn"][$lang] ?? 'HIBA' ?>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="lang-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nyelv kiválasztása</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div id="language-modal-container">
                          <div class="container">
                            <div class="row d-flex align-items-center justify-content-center">
                              <?php foreach (Languages as $index => $language) : ?>
                                <?php $index += 1 ?>
                                <div class="col-12 border p-2 m-1">
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lang" id="lang_<?= $index ?>" value="<?= $index ?>">
                                    <label class="form-check-label" for="lang_2">
                                      <?= $language[$lang] ?>
                                    </label>
                                  </div>
                                </div>
                              <?php endforeach ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= USER_LANGUAGES["modal"]["back"][$lang] ?? 'HIBA' ?></button>
                        <button type="button" class="btn btn-primary" id="language-select-btn"><?= USER_LANGUAGES["modal"]["add"][$lang] ?? 'HIBA' ?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="language-container">

                </div>
              </div>
            </div>






            <div class="col-xs-12 mt-3">
              <div class="form-outline mb-4">
                <label class="form-label" for="other-languages"><b><?= OTHER_LANGUAGES[$lang] ?? 'HIBA' ?></b></label>
                <input type="text" id="other-languages" name="other_languages" class="form-control" value="<?= $prev["other_languages"] ?? '' ?>" placeholder="<?= OTHER_LANGUAGES[$lang] ?? 'HIBA' ?>" />
              </div>
            </div>

            <div class="col-xs-12 mt-3">
              <div class="form-outline mb-4">
                <label class="form-label required" for="participation"><b>
                    <?= PARTICIPATION["title"][$lang] ?? '' ?>
                  </b></label>

                <?php foreach (PARTICIPATION["participations"] as $index => $participation) : ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="participation" id="participation-<?= $index ?>" value="1" <?= isset($prev) && PARTICIPATION["participations"][$prev["participation"]]["Hu"] === $participation["Hu"] ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="participation-<?= $index ?>">
                      <?= $participation[$lang] ?? '' ?>
                    </label>
                  </div>
                <?php endforeach ?>

              </div>
            </div>





            <div class="col-xs-12 mt-3">
              <div class="form-outline mb-4">
                <label class="form-label required" for="informed-by"><b>
                    <?= INFORMED_BY["title"][$lang] ?? 'Honnan hallottál a programról? ' ?>
                  </b></label>
                <?php foreach (INFORMED_BY["inform"] as $index => $info) : ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="informed_by" id="program_<?= $index ?>" value="<?= $index ?>" <?= isset($prev) && INFORMED_BY["inform"][$prev["informed_by"]]["Hu"] === $info["Hu"] ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="program-<?= $index ?>">
                      <?= $info[$lang] ?? 'Név' ?>
                    </label>
                  </div>
                <?php endforeach ?>
              </div>
            </div>


            <div class="col-xs-12 mt-3 border p-3">
              <label for="formFileMultiple" class="form-label mb-3"><b><?= DOCUMENTS["title"][$lang] ?? '' ?></b></label>
              <div id="documents-container"></div>
              <div class="text-center mt-3 mb-5">
                <button type="button" class="btn btn-outline-primary" id="add-document"><?= DOCUMENTS["add_document"][$lang] ?? 'HIBA' ?></button>
              </div>
            </div>
            <div class="mb-4 mt-4">
              <div class="mb-3">
                <b><?= SUBSCRIBE_FORM["choose_time"][$lang] ?? 'HIBA' ?></b>
              </div>
              <div class="btn-group">
                <?php foreach ($dates as $index => $date) : ?>
                  <?php
                  $found = isset($prev["dates"]) ? in_array($date["date"], $prev["dates"]) : '';
                  ?>

                  <input type="checkbox" class="btn-check" id="date-<?= $index ?>" autocomplete="off" name="dates[]" value="<?= $date["date"] ?>" <?= $found ? 'checked' : '' ?>>
                  <label class="btn btn-outline-primary" for="date-<?= $index ?>"><?= $date["date"] ?></label><br>
                <?php endforeach ?>
              </div>
            </div>
            <div class="mb-4">
              <div class="mb-3">
                <b><?= SUBSCRIBE_FORM["choose_task"][$lang] ?? 'HIBA' ?></b>
              </div>
              <?php foreach ($tasks as $index => $task) : ?>
                <?php
                $index += 1;
                $found = isset($prev["tasks"]) ? in_array($task["task"], $prev["tasks"]) : '';
                ?>

                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="task<?= $index ?>" value="<?= $task["task"] ?>" name="tasks[<?= $index ?>]" <?= $found ? 'checked' : '' ?>>
                    <label class="form-check-label" id="task<?= $index ?>"><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></label>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
          </div>




          <div class="text-center">
            <button type="submit" class="btn btn-outline-success"> <?= REGISTRATION["form"]["registrationBtn"][$lang] ?? '' ?></button>
          </div>
      </form>

















    <?php endif ?>


    <script src="/public/js/GetCookie.js"></script>
    <script src="/public/js/User.Documents.js"></script>
    <script src="/public/js/User.Languages.js"></script>