<link rel="stylesheet" href="/public/css/register.css?v=<?php echo time() ?>">
<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

$prev = $params["prev"];
$userLanguages = $prev["userLanguages"] ?? null;

?>

<div class="container" style="background-color: white;">
  <form class="p-lg-3 mb-5" action="/user/register" method="POST" enctype="multipart/form-data">
    <h2 class="text-center mt-5"><?= REGISTRATION["title"][$lang] ?? 'Önkéntes regisztráció' ?></h2>
    <div class="row mb-4 mt-5 m-1">

      <div class="jumbotron border bg-light mb-5 p-2 p-lg-5 ">

        <p class="lead">Ha érdekel az önkéntesség hozd létre a saját fiókodat és értesítést kapsz azokról a művészeti eseményekről, projektekről, galériákról, intézetekről, ahol önkéntes feladatokat tudsz vállalni. Töltsd ki a következő formot.</p>
        <hr class="my-4">
        <p>Regisztrációt követően és a megadott adatokkal való bejelentkezés után az eseményekre lehet jelentkezni (Erre majd valami értelmeset kitalálunk).</p>
      </div>



      <div class="col-xs-12">
        <div class="form-outline">
          <label class="form-label required" for="name"><b><?= REGISTRATION["form"]["name"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="name" name="name" class="form-control" value="<?= $prev["name"] ?? '' ?>" required />
        </div>
      </div>




      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="email"><b><?= REGISTRATION["form"]["email"][$lang] ?? 'Név' ?></b></label>
          <input type="email" id="email" name="email" class="form-control" required value="<?= $prev["email"] ?? '' ?>" />
        </div>
      </div>



      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="password"><b><?= REGISTRATION["form"]["password"][$lang] ?? 'Név' ?></b></label>
          <input type="password" id="password" name="password" class="form-control" required value="<?= $prev["name"] ?? "" ?>" />
        </div>
      </div>


      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="city"><b><?= REGISTRATION["form"]["address"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="address" name="address" class="form-control" required value="<?= $prev["address"] ?? '' ?>" />
        </div>
      </div>




      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label" for="phone"><b><?= REGISTRATION["form"]["mobile"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="phone" name="mobile" class="form-control" value="<?= $prev["mobile"] ?? '' ?>" />
        </div>
      </div>





      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4 text-center">
          <label class="form-label mb-3 required"><b><?= PROFESSIONS["title"][$lang] ?? '' ?></b></label>
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
              <?= EDU_INSTITUTION[$lang] ?? 'Név' ?>
            </b></label>
          <input type="text" id="school-name" name="school_name" class="form-control" value="<?= $prev["school_name"] ?? '' ?>" />
        </div>
      </div>




      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="programs"><b> <?= PROGRAMS["title"][$lang] ?? '' ?></b></label>
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
            <b> <?= LANGUANGE_KNOWLEDGE["title"][$lang] ?? 'Idegennyelv ismeret' ?></b>
          </label>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary m-3" id="lang-modal-btn">
            További nyelvek hozzáadása
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
                        <div class="col-3 border p-2 m-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="lang" id="lang_2" value="1">
                            <label class="form-check-label" for="lang_2">
                              Angol
                            </label>
                          </div>
                        </div>
                        <div class="col-3 border p-2  m-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="lang" id="lang_3" value="2">
                            <label class="form-check-label" for="lang_3">
                              Német
                            </label>
                          </div>
                        </div>
                        <div class="col-3 border p-2  m-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="lang" id="lang_4" value="3">
                            <label class="form-check-label" for="lang_3">
                              Szerb
                            </label>
                          </div>
                        </div>
                        <div class="col-3 border p-2  m-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="lang" id="lang_5" value="4">
                            <label class="form-check-label" for="lang_3">
                              Spanyol
                            </label>
                          </div>
                        </div>
                        <div class="col-3 border p-2 m-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="lang" id="lang_6" value="5">
                            <label class="form-check-label" for="lang_3">
                              Japán
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vissza</button>
                  <button type="button" class="btn btn-primary" id="language-select-btn">Nyelv hozzáadása</button>
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
          <label class="form-label" for="other-languages"><b><?= OTHER_LANGUAGES[$lang] ?? '' ?></b></label>
          <input type="text" id="other-languages" name="other_languages" class="form-control" value="<?= $prev["other_languages"] ?? '' ?>" />
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
          <label class="form-label required" for="voluntary-tasks"><b>
              <td><?= TASK_AREAS["title"][$lang] ?? 'Mely feladatterületek érdekelnek és végeznéd szívesen a vásáron? ' ?></td>
            </b></label>

          <?php foreach (TASK_AREAS["areas"] as $index => $area) : ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="tasks" id="task-<?= $index ?>" value="<?= $index ?>" <?= isset($prev) && TASK_AREAS["areas"][$prev["tasks"]]["Hu"] === $area["Hu"] ? 'checked' : '' ?> required>
              <label class="form-check-label" for="task-1">
                <td><?= $area[$lang] ?? 'Név' ?>
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


      <div class="col-xs-12 mt-3">
        <div class="mb-3">
          <label for="formFileMultiple" class="form-label"><b>Fénykép feltöltése</b></label>
          <input class="form-control" type="file" name="file" />
        </div>
      </div>
      <div class="col-xs-12 mt-3 border p-3">
        <label for="formFileMultiple" class="form-label mb-3"><b><?= UPLOAD_DOCUMENTS["title"][$lang] ?? '' ?></b></label>
        <div id="documents-container"></div>
        <div class="text-center mt-3 mb-5">
          <button type="button" class="btn btn-outline-primary" id="add-document">Új dokumentum</button>
        </div>
      </div>


      <div class="col-xs-12 mt-3 d-flex align-items-center justify-content-center border">
        <div class="form-outline mb-4 p-3">
          <div class="form-check form-switch text-center d-flex align-items-center justify-content-center">
            <input class="form-check-input" style="font-size: 1.5rem;" type="checkbox" id="flexSwitchCheckDefault" name="permission" value="on">
          </div>
          <label class="form-check-label mt-2 text-center" for="flexSwitchCheckDefault">
            <?= REGISTRATION["form"]["email_permission"][$lang] ?? '' ?>
          </label>
        </div>
      </div>
      <div class="col-xs-12 mt-3 d-flex align-items-center justify-content-center border">
        <div class="form-outline mb-4 p-3">
          <div class="form-check form-switch text-center d-flex align-items-center justify-content-center">
            <input class="form-check-input" style="font-size: 1.5rem;" type="checkbox" id="flexSwitchCheckDefault" name="privacy_statement" value="on" required>
          </div>
          <label class="form-check-label mt-2 text-center" for="flexSwitchCheckDefault">
            Elfogadom az <a href="#">adatvédelmi nyilatkozatot</a>
          </label>
        </div>
      </div>

    </div>




    <div class="text-center">
      <button type="submit" class="btn secondary-btn"> <?= REGISTRATION["form"]["registrationBtn"][$lang] ?? '' ?></button>
    </div>
  </form>
</div>