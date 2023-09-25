<link rel="stylesheet" href="/public/css/user/settings.css?v=<?php echo time() ?>">


<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
$user = $params["user"];

$documents = $params["documents"];
$userLanguages = $params["userLanguages"]; 
?>

<div class="border p-4 bg-light container shadow">
  <form id="update-form" action="/user/update" method="POST">
    <div class="row mb-4 mt-5">
      <h2 class="text-center mb-5"><?= PROFILE["profile_settings"]["title"][$lang] ?? 'Név' ?></h2>


      <div class="col-xs-12">
        <div class="form-outline">
          <label class="form-label required" for="name"><b><?= REGISTRATION["form"]["name"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="name" name="name" class="form-control" value="<?= $user["name"] ?? '' ?>" required />
        </div>
      </div>




      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="email"><b><?= REGISTRATION["form"]["email"][$lang] ?? 'Név' ?></b></label>
          <input type="email" id="email" name="email" class="form-control" value="<?= $user["email"] ?>" disabled required />
        </div>
      </div>



      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="password"><b><?= REGISTRATION["form"]["password"][$lang] ?? 'Név' ?></b></label>
          <div>
            <a href="/user/password-reset" class="btn btn-outline-danger"> <?= PROFILE["profile_settings"]["change_password_btn"][$lang] ?? 'Név' ?></a>
          </div>
        </div>
      </div>


      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="city"><b><?= REGISTRATION["form"]["address"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="address" name="address" class="form-control" required value="<?= $user["address"] ?? '' ?>" />
        </div>
      </div>




      <div class="col-xs-12 col-md-6 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label" for="phone"><b><?= REGISTRATION["form"]["mobile"][$lang] ?? 'Név' ?></b></label>
          <input type="text" id="phone" name="mobile" class="form-control" value="<?= $user["mobile"] ?? '' ?>" />
        </div>
      </div>





      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4 text-center">
          <label class="form-label mb-3 required"><b><?= $langs["registration"]["form"]["professions"]["title"][$lang] ?? 'Mivel foglalkozol?' ?></b></label>
          <br>

          <?php foreach (PROFESSIONS["profession"] as $index => $profession) : ?>
            <input type="radio" class="btn-check" name="profession" id="profession_<?= $index ?>" value="<?= $profession['Hu'] ?>" autocomplete="off" required <?php echo $profession['Hu'] === $user["profession"] ? 'checked' :  '' ?>>
            <label class="btn btn-outline-primary" for="profession_<?= $index ?>">
              <?= PROFESSIONS["profession"][$index][$lang] ?? '' ?>
            </label>
          <?php endforeach ?>
        </div>
      </div>




      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label" for="school-name"><b>
              <?= EDU_INSTITUTION[$lang] ?? 'Név' ?>
            </b></label>
          <input type="text" id="school-name" name="school_name" class="form-control" value="<?= $user["schoolName"] ?? '' ?>" />
        </div>
      </div>




      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="programs"><b>
              <?= PROGRAMS["title"][$lang] ?? 'Melyik program érdekel?' ?>
            </b></label>

          <?php foreach (PROGRAMS["program"] as $index => $program) : ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="programs" id="program-<?= $index ?>" value="<?= $index ?>" required <?php echo $program['Hu'] === $user["programs"] ? 'checked' :  '' ?>>
              <label class="form-check-label" for="program-<?= $index ?>">
                <?= $program[$lang] ?>
              </label>
            </div>
          <?php endforeach ?>

        </div>
      </div>






      <div class="col-xs-12 mt-3" id="user-languages" data-langs='<?= json_encode($userLanguages) ?>'>
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
          <label class="form-label" for="other-languages"><b><?= OTHER_LANGUAGES[$lang] ?? 'További nyelvismeret' ?></b></label>
          <input type="text" id="other-languages" name="other_languages" class="form-control" value="<?= $user["otherLanguages"] ?? '' ?>" />
        </div>
      </div>

      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="participation"><b>
              <?= PARTICIPATION["title"][$lang] ?? 'Részt vettél korábban az AMB vagy további képzőművészeti fesztiválon (MÉF, GWB), mint önkéntes?' ?>
            </b></label>
          <?php foreach (PARTICIPATION["participations"] as $index => $participation) : ?>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="participation" id="participation-1" value="<?= $index ?>" required <?php echo $index === (int)$user["participation"] ? 'checked' :  '' ?>>
              <label class="form-check-label" for="program-1">
                <?= $participation[$lang] ?? 'Igen' ?>
              </label>
            </div>
          <?php endforeach ?>
        </div>
      </div>




      <div class="col-xs-12 mt-3">
        <div class="form-outline mb-4">
          <label class="form-label required" for="voluntary-tasks"><b>
              <td><?= $langs["registration"]["form"]["task_area"]["title"][$lang] ?? 'Mely feladatterületek érdekelnek és végeznéd szívesen a vásáron? ' ?></td>
            </b></label>


          <?php foreach (TASK_AREAS["areas"] as $index => $task) : ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="tasks" id="task-1" value="<?= $index ?>" required <?php echo $task["Hu"] === $user["tasks"] ? 'checked' :  '' ?>>
              <label class=" form-check-label" for="task-1">
                <td><?= $task[$lang] ?? 'asd' ?>
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
          <?php foreach (INFORMED_BY["inform"] as $index => $inform) : ?>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="informed_by" id="1" value="<?= $index ?>" required <?php echo $inform["Hu"] === $user["informedBy"] ? 'checked' :  '' ?>>
              <label class="form-check-label" for="program-1">
                <?= $inform[$lang] ?? 'Név' ?>
              </label>
            </div>
          <?php endforeach ?>
        </div>
      </div>


      <div class="col-xs-12 border border-rounded-lg p-3 mb-4 shadow">
        <h1>Feltöltött dokumentumok</h1>
        <p>Jelenleg <b class="text-info" style="font-size: 1.2rem"><?= count($documents)  ?></b> dokumentum van feltöltve</p>
        <?php echo count($documents) !== 0 ? '<a href="/user/documents" class="btn btn-outline-primary">Megtekintés</a>' : '<a href="/user/documents/new" class="btn btn-outline-primary">Dokumentum feltöltése</a>' ?>
      </div>



      <div class="col-xs-12 mt-3 d-flex align-items-center justify-content-center border shadow">
        <div class="form-outline mb-4 p-3">
          <div class="form-check form-switch text-center d-flex align-items-center justify-content-center">
            <input class="form-check-input" style="font-size: 1.5rem;" type="checkbox" id="flexSwitchCheckDefault" name="permission" value="on" <?php echo (int)$user["permission"] === 1 ? 'checked' :  '' ?>>
          </div>
          <label class="form-check-label mt-2 text-center" for="flexSwitchCheckDefault">
            <?= $langs["registration"]["form"]["email_permission"][$lang] ?? 'Szerepeltethetünk-e a következő évek AMB önkéntesi adatbázisban, hogy az Art Marketről szóló újdonságokról elsőkézből értesülj?' ?>
          </label>
        </div>
      </div>
    </div>




    <div class="text-center">
      <button type="button" data-bs-toggle="modal" data-bs-target="#updateProfileModal" class="btn btn-outline-warning"> <?= PROFILE["profile_settings"]["update_profile_button"][$lang] ?? '' ?></button>
      <button type="button" data-bs-toggle="modal" data-bs-target="#deleteProfileModal" class="btn btn-outline-danger"> <?= PROFILE["profile_settings"]["delete_profile_button"][$lang] ?? '' ?></button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateProfileModalLabel">Profil frissitése</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Biztosan frissited a profilodat?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kilépés</button>
            <button type="submit" class="btn btn-primary">Mentés</button>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>
</div>
<div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProfileModalLabel">Profil törlése</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/user/delete" method="POST">
        <div class="modal-body">
          Profil törléséhez ija be a következőt <b class="text-danger border border-danger p-1 rounded"><?= "Delete" . "_" . $user["name"] ?></b>.
          <br>
          <b class="text-danger">A profil törlése végleges!</b>

          <div class="mb-3 mt-3">
            <input type="text" class="form-control" id="deleteProfileInput" name="idForDelete" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kilépés</button>
          <button type="submit" class="btn btn-primary">Mentés</button>
        </div>
      </form>
    </div>
  </div>
</div>