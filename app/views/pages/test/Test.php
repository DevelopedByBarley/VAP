
<div class="container mt-5">
  <div class="row">
    <div class="col-12 mt-5">
      <a href="/">Vissza a kezdőoldalra</a>
    </div>
  </div>
</div>
<div class="login-wrapper d-flex align-items-center justify-content-center" style="min-height: 80vh;">
  <div class="container d-flex align-items-center justify-content-center flex-column rounded" style="min-height: 70vh; background: white;" id="user-login-con">
    <div class="row w-100 d-flex align-items-center justify-content-center">
      <div class="col-12 col-lg-5 d-flex align-items-center justify-content-center" id="login-col">
        <img src="/public/assets/icons/login.jpg" id="login-logo" />
      </div>
      <div class="col-xs-12 col-lg-5 rounded">
        <form action="/user/login" method="POST" id="login" class="w-100">
          <h1 class="text-center">
            <?= $langs["loginForm"]["title"][$lang] ?? 'Bejelentkezés' ?>
          </h1>
          <div class="mb-3 mt-5">
            <label for="email" class="form-label"><?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?></label>
            <input type="email" class="form-control rounded" id="email" aria-describedby="emailHelp" name="email" placeholder="<?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?>">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label"><?= $langs["loginForm"]["password"][$lang] ?? 'Jelszó' ?></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="<?= $langs["loginForm"]["password"][$lang] ?? 'Email cim' ?>">
          </div>
          <div class="text-center mt-5">
            <button type="submit" class="btn secondary-btn"><?= $langs["loginForm"]["loginBtn"][$lang] ?? 'Bejelentkezés' ?></button>
            <p class="mt-3">Forgot <a href="/user/forgot-pw">Password?</a></p>
          </div>
          <div class="mt-5 text-center">
            <a href="/user/registration" class="text-info" style="text-decoration: none;">Create your account <i class="bi bi-arrow-right"></i></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>






























  <form class="p-3" style="background-color: white;;" action="/event/register/<?= $event["eventId"] ?>" method="POST" enctype="multipart/form-data">
    <h3 class="text-center mb-5 mt-5">Jelentkezés kitöltése</h3>

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