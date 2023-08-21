<?php
$event = $params["event"];
$dates = $params["dates"];
$tasks = $params["tasks"];
$user = $params["user"];
$userLanguages = $params["userLanguages"];



$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$langs = LANGS;
?>


<div class="row">
  <div class="col-xs-12">
    <form action="/user/event/register" method="POST" id="register-form" class="shadow p-3">
      <div class="row mb-4 mt-5">


        <div class="col-xs-12">
          <div class="form-outline">
            <label class="form-label required" for="name"><b><?= REGISTRATION["form"]["name"][$lang] ?? 'Név' ?></b></label>
            <input type="text" id="name" name="name" class="form-control" value="<?= $user["name"] ?? '' ?>" required />
          </div>
        </div>




        <div class="col-xs-12 col-md-6 mt-3">
          <div class="form-outline mb-4">
            <label class="form-label required" for="email"><b><?= REGISTRATION["form"]["email"][$lang] ?? 'Név' ?></b></label>
            <input type="email" id="email" name="email" class="form-control" value="<?= $user["email"] ?? '' ?>" disabled required />
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
          <div class="form-outline mb-4">
            <label class="form-label" for="school-name"><b>
                <?= EDU_INSTITUTION[$lang] ?? 'Név' ?>
              </b></label>
            <input type="text" id="school-name" name="school_name" class="form-control" value="<?= $user["schoolName"] ?? '' ?>" />
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
                <input class="form-check-input" type="radio" name="participation" id="participation-1" value="<?= $index ?>" required <?php echo $user && $index === (int)$user["participation"] ? 'checked' :  '' ?>>
                <label class="form-check-label" for="program-1">
                  <?= $participation[$lang] ?? 'Igen' ?>
                </label>
              </div>
            <?php endforeach ?>
          </div>
        </div>



        <div class="btn-group">
          <?php foreach ($dates as $index => $date) : ?>

            <input type="checkbox" class="btn-check" id="date-<?= $index ?>" autocomplete="off" value="<?= $date["date"] ?>">
            <label class="btn btn-outline-primary" for="date-<?= $index ?>"><?= $date["date"] ?></label><br>
          <?php endforeach ?>
        </div>

        <?php foreach ($tasks as $index => $task) : ?>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="task<?= $index ?>" value="<?= $index ?>" name="tasks[]">
              <label class="form-check-label" id="task<?= $index ?>"><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></label>
            </div>
          </div>
        <?php endforeach ?>



        <div>
          <button type="submit" class="btn btn-outline-primary">Regisztráció</button>
        </div>

    </form>
  </div>
</div>