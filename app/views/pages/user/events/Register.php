<link rel="stylesheet" href="/public/css/user/register.css">

<?php
$event = $params["event"];
$dates = $params["dates"];
$tasks = $params["tasks"];
$user = $params["user"];
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$langs = LANGS;
?>


  <div class="p-3 r-border " id="register-form">
    <h1 class="text-center mb-5 mt-3"><?= $event[languageSwitcher("name")] ?> jelentkezés</h1>
    <?php if ($user) : ?>
      <div class="row" id="register-profile">
        <div class="col-xs-12 text-center" id="register-profile-header">
          <img src="/public/assets/uploads/images/users/<?= $user["fileName"] ?>" alt="" style="height: 150px; width: 150px;" class="mb-3">
          <h3><?= $user["name"] ?? '' ?></h3>
          <p><?= $user["email"] ?? '' ?></p>
          <a href="/user/dashboard" class="btn btn-outline-primary">Profil áttekintése</a>
        </div>
        <div class="text-center mb-5">
          <small>Bejelentkezett állapot esetén a profil adataival történik a regisztráció</small>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <form action="/event/register/<?= $event["eventId"] ?>" method="POST">
            <div class="mb-4">
              <div class="mb-3">
                <b>Válassza ki az önnek megfelelő időpontot</b>
              </div>
              <div class="btn-group">
                <?php foreach ($dates as $index => $date) : ?>
                  <input type="checkbox" class="btn-check" id="date-<?= $index ?>" autocomplete="off" name="dates[]" value="<?= $date["date"] ?>">
                  <label class="btn btn-outline-primary" for="date-<?= $index ?>"><?= $date["date"] ?></label><br>
                <?php endforeach ?>
              </div>
            </div>
            <div class="mb-4">
              <div class="mb-3">
                <b>Válassza ki az ön számára megfelelő feladatokat</b>
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
              <button type="submit" class="btn btn-outline-primary">Regisztráció</button>
            </div>

          </form>
        </div>
      </div>
  </div>
<?php else : ?>




































  <form class="border shadow p-3" action="/event/register/<?= $event["eventId"] ?>" method="POST" enctype="multipart/form-data">
    <div class="row mb-4 mt-5">


      <div class="col-xs-12">
        <div class="form-outline">
          <label class="form-label required" for="name"><b><?= REGISTRATION["form"]["name"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="name" name="name" class="form-control" required />
        </div>
      </div>




      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="email"><b><?= REGISTRATION["form"]["email"][$lang] ?? 'Név' ?></b></label>
          <input type="email" id="email" name="email" class="form-control" required />
        </div>
      </div>


      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="city"><b><?= REGISTRATION["form"]["address"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="address" name="address" class="form-control" required />
        </div>
      </div>




      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label" for="phone"><b><?= REGISTRATION["form"]["mobile"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="phone" name="mobile" class="form-control" />
        </div>
      </div>





      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4 text-center">
          <label class="form-label mb-3 required"><b><?= PROFESSIONS["title"][$lang] ?? '' ?></b></label>
          <br>
          <input type="radio" class="btn-check" name="profession" id="profession_1" value="<?= PROFESSIONS["profession"]["student"]['Hu'] ?>" autocomplete="off" required>
          <label class="btn btn-outline-primary" for="profession_1">
            <?= PROFESSIONS["profession"]["student"][$lang] ?? 'Diák vagyok' ?>
          </label>

          <input type="radio" class="btn-check" name="profession" id="profession_2" value="<?= PROFESSIONS["profession"]["student"]['Hu'] ?>" autocomplete="off">
          <label class="btn btn-outline-primary" for="profession_2">
            <?= PROFESSIONS["profession"]["worker"][$lang] ?? 'Dolgozok' ?>
          </label>
        </div>
      </div>




      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label" for="school-name"><b>
              <?= EDU_INSTITUTION[$lang] ?? 'Név' ?>
            </b></label>
          <input type="text" id="school-name" name="school_name" class="form-control" />
        </div>
      </div>




      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="programs"><b> <?= PROGRAMS["title"][$lang] ?? '' ?></b></label>
          <?php foreach (PROGRAMS["program"] as $index => $program) : ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="programs" id="program-<?= $index ?>" value="<?= $index ?>" required>
              <label class="form-check-label" for="program-<?= $index ?>">
                <?= $program[$lang] ?? '' ?>
              </label>
            </div>
          <?php endforeach ?>
        </div>
      </div>





      <div class="col-xs-12 mt-3">
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
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="lang" id="lang_2" value="1">
                      <label class="form-check-label" for="lang_2">
                        Angol
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="lang" id="lang_3" value="2">
                      <label class="form-check-label" for="lang_3">
                        Német
                      </label>
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
          <input type="text" id="other-languages" name="other_languages" class="form-control" />
        </div>
      </div>

      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="participation"><b>
              <?= PARTICIPATION["title"][$lang] ?? '' ?>
            </b></label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="participation" id="participation-1" value="1" required>
            <label class="form-check-label" for="program-1">
              <?= PARTICIPATION["participations"]["1"][$lang] ?? '' ?>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="participation" id="participation-2" value="2">
            <label class="form-check-label" for="program-2">
              <?= PARTICIPATION["participations"]["2"][$lang] ?? '' ?>
            </label>
          </div>
        </div>
      </div>







      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="informed-by"><b>
              <?= INFORMED_BY["title"][$lang] ?? 'Honnan hallottál a programról? ' ?>
            </b></label>
          <?php foreach (INFORMED_BY["inform"] as $index => $info) : ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="informed_by" id="program_<?= $index ?>" value="<?= $index ?>" required>
              <label class="form-check-label" for="program-<?= $index ?>">
                <?= $info[$lang] ?? 'Név' ?>
              </label>
            </div>
          <?php endforeach ?>
        </div>
      </div>


      <div class="col-xs-12 mt-3 border p-3">
        <label for="formFileMultiple" class="form-label mb-3"><b><?= UPLOAD_DOCUMENTS["title"][$lang] ?? '' ?></b></label>
        <div id="documents-container"></div>
        <div class="text-center mt-3 mb-5">
          <button type="button" class="btn btn-outline-primary" id="add-document">Új dokumentum</button>
        </div>
      </div>
      <div class="mb-4 mt-4">
        <div class="mb-3">
          <b>Válassza ki az önnek megfelelő időpontot</b>
        </div>
        <div class="btn-group">
          <?php foreach ($dates as $index => $date) : ?>
            <input type="checkbox" class="btn-check" id="date-<?= $index ?>" autocomplete="off" name="dates[]" value="<?= $date["date"] ?>">
            <label class="btn btn-outline-primary" for="date-<?= $index ?>"><?= $date["date"] ?></label><br>
          <?php endforeach ?>
        </div>
      </div>
      <div class="mb-4">
        <div class="mb-3">
          <b>Válassza ki az ön számára megfelelő feladatokat</b>
        </div>
        <?php foreach ($tasks as $index => $task) : ?>
          <?php $index += 1 ?>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="task<?= $index ?>" value="<?= $task["task"] ?>" name="tasks[<?= $index ?>]">
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
