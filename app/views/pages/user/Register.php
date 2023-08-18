<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>

<form class="border shadow p-3" id="register-form" action="/user/register" method="POST" enctype="multipart/form-data">
  <h1 class="text-center display-5 mt-5"><?= REGISTRATION["title"][$lang] ?? 'Önkéntes regisztráció' ?></h1>
  <div class="row mb-4 mt-5">

    <div class="jumbotron border bg-light mb-5 p-5 ">

      <p class="lead">Ha érdekel az önkéntesség hozd létre a saját fiókodat és értesítést kapsz azokról a művészeti eseményekről, projektekről, galériákról, intézetekről, ahol önkéntes feladatokat tudsz vállalni. Töltsd ki a következő formot.</p>
      <hr class="my-4">
      <p>Regisztrációt követően és a megadott adatokkal való bejelentkezés után az eseményekre lehet jelentkezni (Erre majd valami értelmeset kitalálunk).</p>
    </div>



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
        <label class="form-label required" for="password"><b><?= REGISTRATION["form"]["password"][$lang] ?? 'Név' ?></b></label>
        <input type="password" id="password" name="password" class="form-control" required />
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
        <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
          Nyelv kiválasztása
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nyelv kiválasztása</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="language-modal-container">

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vissza</button>
                <button type="button" class="btn btn-primary">Nyelv hozzáadása</button>
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
        <label class="form-label required" for="voluntary-tasks"><b>
            <td><?= TASK_AREAS["title"][$lang] ?? 'Mely feladatterületek érdekelnek és végeznéd szívesen a vásáron? ' ?></td>
          </b></label>

        <?php foreach (TASK_AREAS["areas"] as $index => $area) : ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tasks" id="task-<?= $index ?>" value="<?= $index ?>" required>
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
            <input class="form-check-input" type="radio" name="informed_by" id="program_<?= $index ?>" value="<?= $index ?>" required>
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

  </div>




  <div class="text-center">
    <button type="submit" class="btn btn-outline-success"> <?= REGISTRATION["form"]["registrationBtn"][$lang] ?? '' ?></button>
  </div>
</form>