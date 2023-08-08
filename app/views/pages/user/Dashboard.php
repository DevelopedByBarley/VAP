<?php
$user = $params["user"];
$documents = $params["documents"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>


<?php echo $params["alertContent"]; ?>




<div id="dashboard" class="w-100 mt-5">
  <div id="dashboard-header" class="w-100 d-flex align-items-center justify-content-center flex-column text-light shadow mt-4">
    <div class="text-center mb-2">
      <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" style="height: 150px; width: 150px; border-radius: 100%;" class="shadow" />
    </div>

    <h1 class="text-center display-6"><?= $user["name"] ?></h1>
    <b>
      <p class="text-center"><?= $user["email"] ?></p>
    </b>
    <p class="text-center"><?= $langs["profile"]["header"]["createdAt"][$lang] ?? 'Név' ?>: <?= date("y-d-m h:i", $user["createdAt"]) ?></p>
    <div class="text-center">
      <a href="/user/logout" class="m-1 btn btn-danger text-light" id="user-logout-button">
        <?= $langs["profile"]["header"]["logoutBtn"][$lang] ?? 'Név' ?>
      </a>
    </div>
  </div>

  <div id="subscriptions" class="border mt-3 mb-5 p-4 bg-light">
    <h2 class="text-center mt-5"> <?= $langs["profile"]["subscriptions"]["title"][$lang] ?? 'Név' ?></h2>

    <?php if (!isset($subscriptions) || count($subscriptions) === 0) : ?>
      <h5 class="text-center"><?= $langs["profile"]["subscriptions"]["no_subscriptions"][$lang] ?? 'Név' ?></h5>
      <div class="text-center">
        <a href="/asd" class="m-1 btn text-light" id="event-btn">
          <?= $langs["profile"]["subscriptions"]["check_subscription_btn"][$lang] ?? 'Név' ?>
        </a>
      </div>
    <?php endif ?>
  </div>


  <div id="profile-settings" class="border p-4 shadow">
    <form id="update-form" action="/user/update" method="POST">
      <div class="row mb-4 mt-5">
        <h2 class="text-center mb-5"><?= $langs["profile"]["profile_settings"]["title"][$lang] ?? 'Név' ?></h2>


        <div class="col-xs-12">
          <div class="form-outline">
            <label class="form-label required" for="name"><b><?= $langs["registration"]["form"]["name"][$lang] ?? 'Név' ?></b></label>
            <input type="text" id="name" name="name" class="form-control" value="<?= $user["name"] ?? '' ?>" required />
          </div>
        </div>




        <div class="col-xs-12 col-md-6 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="email"><b><?= $langs["registration"]["form"]["email"][$lang] ?? 'Név' ?></b></label>
            <input type="email" id="email" name="email" class="form-control"  value="<?= $user["email"] ?>" disabled required/>
          </div>
        </div>



        <div class="col-xs-12 col-md-6 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="password"><b><?= $langs["registration"]["form"]["password"][$lang] ?? 'Név' ?></b></label>
            <div>
              <a href="/user/password-reset" class="btn btn-outline-danger"> <?= $langs["profile"]["profile_settings"]["change_password_btn"][$lang] ?? 'Név' ?></a>
            </div>
          </div>
        </div>


        <div class="col-xs-12 col-md-6 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="city"><b><?= $langs["registration"]["form"]["address"][$lang] ?? 'Név' ?></b></label>
            <input type="text" id="address" name="address" class="form-control" required value="<?= $user["address"] ?? '' ?>" />
          </div>
        </div>




        <div class="col-xs-12 col-md-6 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label" for="phone"><b><?= $langs["registration"]["form"]["mobile"][$lang] ?? 'Név' ?></b></label>
            <input type="text" id="phone" name="mobile" class="form-control" value="<?= $user["mobile"] ?? '' ?>" />
          </div>
        </div>





        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4 text-center">
            <label class="form-label mb-3 required"><b><?= $langs["registration"]["form"]["professions"]["title"][$lang] ?? 'Mivel foglalkozol?' ?></b></label>
            <br>

            <?php foreach (PROFESSIONS as $index => $profession) : ?>
              <input type="radio" class="btn-check" name="profession" id="profession_<?= $index ?>" value="<?= $profession['Hu'] ?>" autocomplete="off" required <?php echo $profession['Hu'] === $user["profession"] ? 'checked' :  '' ?>>
              <label class="btn btn-outline-primary" for="profession_<?= $index ?>">
                <?= $langs["registration"]["form"]["professions"]["profession"][$index][$lang] ?? '' ?>
              </label>
            <?php endforeach ?>
          </div>
        </div>




        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label" for="school-name"><b>
                <?= $langs["registration"]["form"]["edu_institution"][$lang] ?? 'Név' ?>
              </b></label>
            <input type="text" id="school-name" name="school_name" class="form-control" value="<?= $user["schoolName"] ?? '' ?>" />
          </div>
        </div>




        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="programs"><b>
                <?= $langs["registration"]["form"]["programs"]["title"][$lang] ?? 'Melyik program érdekel?' ?>
              </b></label>

            <?php foreach (PROGRAMS as $index => $program) : ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="programs" id="program-<?= $index ?>" value="<?= $index ?>" required <?php echo $program['Hu'] === $user["programs"] ? 'checked' :  '' ?>>
                <label class="form-check-label" for="program-<?= $index ?>">
                  <?= $langs["registration"]["form"]["programs"][$index][$lang] ?? 'Név' ?>
                </label>
              </div>
            <?php endforeach ?>

          </div>
        </div>





        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4">
            <label class="form-check-label required" for="languages">
              <b> <?= $langs["registration"]["form"]["language_knowledge"]["title"][$lang] ?? 'Idegennyelv ismeret' ?></b>
            </label>
            <div class="table-responsive">
              <table class="table" id="languages">
                <thead>
                  <tr>
                    <th><?= $langs["registration"]["form"]["language_knowledge"]["language"][$lang] ?? 'Név' ?></th>
                    <th><?= $langs["registration"]["form"]["language_knowledge"]["basic"][$lang] ?? 'Név' ?></th>
                    <th><?= $langs["registration"]["form"]["language_knowledge"]["advanced"][$lang] ?? 'Név' ?></th>
                    <th><?= $langs["registration"]["form"]["language_knowledge"]["higher"][$lang] ?? 'Név' ?></th>
                    <th><?= $langs["registration"]["form"]["language_knowledge"]["dont_speek"][$lang] ?? 'Név' ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["English"][$lang] ?? 'Név' ?></td>
                    <?php foreach (LANGUAGE_KNOWLEDGE["English"] as $index => $language) : ?>

                      <td><input class="form-check-input" type="radio" name="english" value="<?= $index + 1 ?>" required <?php echo $language === (int)$user["english"] ? 'checked' :  '' ?>></td>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Germany"][$lang] ?? 'Név' ?></td>

                    <?php foreach (LANGUAGE_KNOWLEDGE["Germany"] as $index => $language) : ?>
                      <td><input class="form-check-input" type="radio" name="germany" value="<?= $index + 1 ?>" required <?php echo $language === (int)$user["germany"] ? 'checked' :  '' ?>></td>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Italy"][$lang] ?? 'Név' ?></td>
                    <?php foreach (LANGUAGE_KNOWLEDGE["Italy"] as $index => $language) : ?>
                      <td><input class="form-check-input" type="radio" name="italy" value="<?= $index + 1 ?>" required <?php echo $language === (int)$user["italy"] ? 'checked' :  '' ?>></td>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Serbian"][$lang] ?? 'Név' ?></td>
                    <?php foreach (LANGUAGE_KNOWLEDGE["Serbian"] as $index => $language) : ?>
                      <td><input class="form-check-input" type="radio" name="serbian" value="<?= $index + 1 ?>" required <?php echo $language === (int)$user["serbian"] ? 'checked' :  '' ?>></td>
                    <?php endforeach ?>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>





        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label" for="other-languages"><b><?= $langs["registration"]["form"]["other_languages"][$lang] ?? 'További nyelvismeret' ?></b></label>
            <input type="text" id="other-languages" name="other_languages" class="form-control" value="<?= $user["otherLanguages"] ?? '' ?>" />
          </div>
        </div>

        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="participation"><b>
                <?= $langs["registration"]["form"]["participation"]["title"][$lang] ?? 'Részt vettél korábban az AMB vagy további képzőművészeti fesztiválon (MÉF, GWB), mint önkéntes?' ?>
              </b></label>
            <?php foreach (PARTICIPATIONS as $index => $participation) : ?>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="participation" id="participation-1" value="<?= $index ?>" required <?php echo $index === (int)$user["participation"] ? 'checked' :  '' ?>>
                <label class="form-check-label" for="program-1">
                  <?= $langs["registration"]["form"]["participation"][$index][$lang] ?? 'Igen' ?>
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


            <?php foreach (TASK_AREAS as $index => $task) : ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="tasks" id="task-1" value="<?= $index ?>" required <?php echo $task["Hu"] === $user["tasks"] ? 'checked' :  '' ?>>
                <label class=" form-check-label" for="task-1">
                  <td><?= $langs["registration"]["form"]["task_area"]["areas"][$index][$lang] ?? 'asd' ?>
                </label>
              </div>
            <?php endforeach ?>
          </div>
        </div>







        <div class="col-xs-12 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="informed-by"><b>
                <?= $langs["registration"]["form"]["informedBy"]["title"][$lang] ?? 'Honnan hallottál a programról? ' ?>
              </b></label>
            <?php foreach (INFORMED_BY as $index => $inform) : ?>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="informed_by" id="1" value="<?= $index ?>" required <?php echo $inform["Hu"] === $user["informedBy"] ? 'checked' :  '' ?>>
                <label class="form-check-label" for="program-1">
                  <?= $langs["registration"]["form"]["informedBy"]["inform"][$index][$lang] ?? 'Név' ?>
                </label>
              </div>
            <?php endforeach ?>
          </div>
        </div>


        <div class="col-xs-12 border border-rounded-lg p-3 mb-4 shadow">
          <h1 class="display-6">Feltöltött dokumentumok</h1>
            <p>Jelenleg <b class="text-info" style="font-size: 1.2rem"><?= count($documents)  ?></b> dokumentum van feltöltve</p>
            <?php echo count($documents) !== 0 ? '<a href="/user/documents" class="btn btn-outline-primary">Megtekintés</a>' : '<a href="/user/documents/new" class="btn btn-outline-primary">Dokumentum feltöltése</a>'?>
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
        <button type="button" data-bs-toggle="modal" data-bs-target="#updateProfileModal" class="btn btn-outline-warning"> <?= $langs["profile"]["profile_settings"]["update_profile_button"][$lang] ?? 'Profil frissitése' ?></button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteProfileModal" class="btn btn-outline-danger"> <?= $langs["profile"]["profile_settings"]["delete_profile_button"][$lang] ?? 'Profil törlése' ?></button>
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