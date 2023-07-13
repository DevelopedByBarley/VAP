<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>

<form class="p-3" id="register-form" action="/user/register" method="POST">
  <h1 class="text-center display-5"><?= $langs["registration"]["title"][$lang] ?? 'Önkéntes regisztráció' ?></h1>
  <div class="row mb-4 mt-5">



    <div class="col-xs-12">
      <div class="form-outline">
        <label class="form-label required" for="name"><b><?= $langs["registration"]["form"]["name"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="name" name="name" class="form-control" required />
      </div>
    </div>




    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="email"><b><?= $langs["registration"]["form"]["email"][$lang] ?? 'Név' ?></b></label>
        <input type="email" id="email" name="email" class="form-control" required />
      </div>
    </div>



    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="password"><b><?= $langs["registration"]["form"]["password"][$lang] ?? 'Név' ?></b></label>
        <input type="password" id="password" name="password" class="form-control" required />
      </div>
    </div>


    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="city"><b><?= $langs["registration"]["form"]["address"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="address" name="address" class="form-control" required />
      </div>
    </div>




    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="phone"><b><?= $langs["registration"]["form"]["mobile"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="phone" name="mobile" class="form-control" />
      </div>
    </div>





    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4 text-center">
        <label class="form-label mb-3 required"><b><?= $langs["registration"]["form"]["professions"]["profession"]["title"][$lang] ?? 'Mivel foglalkozol?' ?></b></label>
        <br>
        <input type="radio" class="btn-check" name="profession" id="profession_1" value="<?= $langs["registration"]["form"]["professions"]["profession"]["student"]['Hu'] ?>" autocomplete="off" required>
        <label class="btn btn-outline-primary" for="profession_1">
          <?= $langs["registration"]["form"]["professions"]["profession"]["student"][$lang] ?? 'Diák vagyok' ?>
        </label>

        <input type="radio" class="btn-check" name="profession" id="profession_2" value="<?= $langs["registration"]["form"]["professions"]["profession"]["student"]['Hu'] ?>" autocomplete="off">
        <label class="btn btn-outline-primary" for="profession_2">
          <?= $langs["registration"]["form"]["professions"]["profession"]["worker"][$lang] ?? 'Dolgozok' ?>
        </label>
      </div>
    </div>




    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="school-name"><b>
            <?= $langs["registration"]["form"]["edu_institution"][$lang] ?? 'Név' ?>
          </b></label>
        <input type="text" id="school-name" name="school_name" class="form-control" />
      </div>
    </div>




    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="programs"><b>
            <?= $langs["registration"]["form"]["programs"]["title"][$lang] ?? 'Melyik program érdekel?' ?>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-1" value="program_1" required>
          <label class="form-check-label" for="program-1">
            <?= $langs["registration"]["form"]["programs"]["program_1"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-2" value="program_2">
          <label class="form-check-label" for="program-2">
            <?= $langs["registration"]["form"]["programs"]["program_2"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-3" value="program_3">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["programs"]["program_3"][$lang] ?? 'Név' ?>
          </label>
        </div>
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
                <td><input class="form-check-input" type="radio" name="english" value="1" required></td>
                <td><input class="form-check-input" type="radio" name="english" value="2"></td>
                <td><input class="form-check-input" type="radio" name="english" value="3"></td>
                <td><input class="form-check-input" type="radio" name="english" value="4"></td>
              </tr>
              <tr>
                <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Germany"][$lang] ?? 'Név' ?></td>
                <td><input class="form-check-input" type="radio" name="germany" value="1" required></td>
                <td><input class="form-check-input" type="radio" name="germany" value="2"></td>
                <td><input class="form-check-input" type="radio" name="germany" value="3"></td>
                <td><input class="form-check-input" type="radio" name="germany" value="4"></td>
              </tr>
              <tr>
                <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Italy"][$lang] ?? 'Név' ?></td>
                <td><input class="form-check-input" type="radio" name="italy" value="1" required></td>
                <td><input class="form-check-input" type="radio" name="italy" value="2"></td>
                <td><input class="form-check-input" type="radio" name="italy" value="3"></td>
                <td><input class="form-check-input" type="radio" name="italy" value="4"></td>
              </tr>
              <tr>
                <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Serbian"][$lang] ?? 'Név' ?></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="1" required></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="2"></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="3"></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="4"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>





    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="other-languages"><b><?= $langs["registration"]["form"]["other_languages"][$lang] ?? 'További nyelvismeret' ?></b></label>
        <input type="text" id="other-languages" name="other_languages" class="form-control" />
      </div>
    </div>

    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="participation"><b>
            <?= $langs["registration"]["form"]["participation"]["title"][$lang] ?? 'Részt vettél korábban az AMB vagy további képzőművészeti fesztiválon (MÉF, GWB), mint önkéntes?' ?>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="participation" id="participation-1" value="1" required>
          <label class="form-check-label" for="program-1">
            <?= $langs["registration"]["form"]["participation"]["1"][$lang] ?? 'Igen' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="participation" id="participation-2" value="2">
          <label class="form-check-label" for="program-2">
            <?= $langs["registration"]["form"]["participation"]["2"][$lang] ?? 'Nem' ?>
          </label>
        </div>
      </div>
    </div>




    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="voluntary-tasks"><b>
            <td><?= $langs["registration"]["form"]["task_area"]["title"][$lang] ?? 'Mely feladatterületek érdekelnek és végeznéd szívesen a vásáron? ' ?></td>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-1" value="1" required>
          <label class="form-check-label" for="task-1">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["1"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-2" value="2">
          <label class="form-check-label" for="task-2">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["2"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-3" value="3">
          <label class="form-check-label" for="task-3">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["3"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-4" value="4">
          <label class="form-check-label" for="task-4">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["4"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-5" value="5">
          <label class="form-check-label" for="task-5">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["5"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-6" value="6">
          <label class="form-check-label" for="task-6">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["6"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-7" value="7">
          <label class="form-check-label" for="task-7">
            <td><?= $langs["registration"]["form"]["task_area"]["areas"]["7"][$lang] ?? 'Név' ?>
          </label>
        </div>
      </div>
    </div>







    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label required" for="informed-by"><b>
            <?= $langs["registration"]["form"]["informedBy"]["title"][$lang] ?? 'Honnan hallottál a programról? ' ?>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="informed_by" id="1" value="1" required>
          <label class="form-check-label" for="program-1">
            <?= $langs["registration"]["form"]["informedBy"]["inform"]["1"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="informed_by" id="2" value="2">
          <label class="form-check-label" for="program-2">
            <?= $langs["registration"]["form"]["informedBy"]["inform"]["2"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="informed_by" id="3" value="3">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["informedBy"]["inform"]["3"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="informed_by" id="3" value="4">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["informedBy"]["inform"]["4"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="informed_by" id="5" value="5">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["informedBy"]["inform"]["5"][$lang] ?? 'Név' ?>
          </label>
        </div>
      </div>
    </div>






    <div class="col-xs-12 mt-3 d-flex align-items-center justify-content-center border">
      <div class="form-outline mb-4 p-3">
        <div class="form-check form-switch text-center d-flex align-items-center justify-content-center">
          <input class="form-check-input" style="font-size: 1.5rem;" type="checkbox" id="flexSwitchCheckDefault" name="permission" value="on">
        </div>
        <label class="form-check-label mt-2 text-center" for="flexSwitchCheckDefault">
          <?= $langs["registration"]["form"]["email_permission"][$lang] ?? 'Szerepeltethetünk-e a következő évek AMB önkéntesi adatbázisban, hogy az Art Marketről szóló újdonságokról elsőkézből értesülj?' ?>
        </label>
      </div>
    </div>

  </div>




  <div class="text-center">
    <button type="submit" class="btn btn-outline-success"> <?= $langs["registration"]["form"]["registrationBtn"][$lang] ?? 'Rdsadegisztráció' ?></button>
  </div>
</form>