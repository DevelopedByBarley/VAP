<?php
require 'config/lang/lang.php';
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
?>

<form class="p-5" id="register-form" action="/user/register" method="POST">
  <h1 class="text-center"><?= $langs["registration"]["title"][$lang] ?? 'Önkéntes regisztráció' ?></h1>
  <div class="row mb-4 mt-5">



    <div class="col-xs-12">
      <div class="form-outline">
        <label class="form-label" for="name"><b><?= $langs["registration"]["form"]["name"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="name" name="name" class="form-control" required />
      </div>
    </div>




    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="email"><b><?= $langs["registration"]["form"]["email"][$lang] ?? 'Név' ?></b></label>
        <input type="email" id="email" name="email" class="form-control" required />
      </div>
    </div>



    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="password"><b><?= $langs["registration"]["form"]["password"][$lang] ?? 'Név' ?></b></label>
        <input type="password" id="password" name="password" class="form-control" required />
      </div>
    </div>

    
    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="city"><b><?= $langs["registration"]["form"]["address"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="city" name="city" class="form-control" required />
      </div>
    </div>




    <div class="col-xs-12 col-md-6 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="phone"><b><?= $langs["registration"]["form"]["mobile"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="phone" name="phone" class="form-control" />
      </div>
    </div>





    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4 text-center">
        <label class="form-label mb-3"><b><?= $langs["registration"]["form"]["professions"]["title"][$lang] ?? 'Név' ?></b></label>
        <br>
        <input type="radio" class="btn-check" name="profession" id="profession_1" value="student" autocomplete="off">
        <label class="btn btn-outline-primary" for="profession_1">
          <?= $langs["registration"]["form"]["professions"]["student"][$lang] ?? 'Név' ?>
        </label>

        <input type="radio" class="btn-check" name="profession" id="profession_2" value="worker" autocomplete="off">
        <label class="btn btn-outline-primary" for="profession_2">
          <?= $langs["registration"]["form"]["professions"]["worker"][$lang] ?? 'Név' ?>
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
        <label class="form-label" for="programs"><b>
            <?= $langs["registration"]["form"]["programs"]["title"][$lang] ?? 'Név' ?>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-1" value="option2">
          <label class="form-check-label" for="program-1">
            <?= $langs["registration"]["form"]["programs"]["program_1"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-2" value="option3">
          <label class="form-check-label" for="program-2">
            <?= $langs["registration"]["form"]["programs"]["program_2"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-3" value="option3">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["programs"]["program_3"][$lang] ?? 'Név' ?>
          </label>
        </div>
      </div>
    </div>





    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-check-label" for="languages">
          <b> <?= $langs["registration"]["form"]["language_knowledge"]["title"][$lang] ?? 'Név' ?></b>
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
                <td><input class="form-check-input" type="radio" name="english" value="alap"></td>
                <td><input class="form-check-input" type="radio" name="english" value="halado"></td>
                <td><input class="form-check-input" type="radio" name="english" value="felsofok"></td>
                <td><input class="form-check-input" type="radio" name="english" value="nembeszelem"></td>
              </tr>
              <tr>
                <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Germany"][$lang] ?? 'Név' ?></td>
                <td><input class="form-check-input" type="radio" name="germany" value="alap"></td>
                <td><input class="form-check-input" type="radio" name="germany" value="halado"></td>
                <td><input class="form-check-input" type="radio" name="germany" value="felsofok"></td>
                <td><input class="form-check-input" type="radio" name="germany" value="nembeszelem"></td>
              </tr>
              <tr>
                <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Italy"][$lang] ?? 'Név' ?></td>
                <td><input class="form-check-input" type="radio" name="italy" value="alap"></td>
                <td><input class="form-check-input" type="radio" name="italy" value="halado"></td>
                <td><input class="form-check-input" type="radio" name="italy" value="felsofok"></td>
                <td><input class="form-check-input" type="radio" name="italy" value="nembeszelem"></td>
              </tr>
              <tr>
                <td><?= $langs["registration"]["form"]["language_knowledge"]["languages"]["Serbian"][$lang] ?? 'Név' ?></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="alap"></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="halado"></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="felsofok"></td>
                <td><input class="form-check-input" type="radio" name="serbian" value="nembeszelem"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>





    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="additional-language"><b><?= $langs["registration"]["form"]["other_languages"][$lang] ?? 'Név' ?></b></label>
        <input type="text" id="additional-language" name="additional_language" class="form-control" />
      </div>
    </div>





    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="voluntary-tasks"><b>
            <td><?= $langs["registration"]["form"]["task_area"]["title"][$lang] ?? 'Név' ?></td>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-1" value="option2">
          <label class="form-check-label" for="task-1">
            <td><?= $langs["registration"]["form"]["task_area"]["area_1"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-2" value="option3">
          <label class="form-check-label" for="task-2">
            <td><?= $langs["registration"]["form"]["task_area"]["area_2"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-3" value="option3">
          <label class="form-check-label" for="task-3">
            <td><?= $langs["registration"]["form"]["task_area"]["area_3"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-4" value="option3">
          <label class="form-check-label" for="task-4">
            <td><?= $langs["registration"]["form"]["task_area"]["area_4"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-5" value="option3">
          <label class="form-check-label" for="task-5">
            <td><?= $langs["registration"]["form"]["task_area"]["area_5"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-6" value="option3">
          <label class="form-check-label" for="task-6">
            <td><?= $langs["registration"]["form"]["task_area"]["area_6"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tasks" id="task-7" value="option3">
          <label class="form-check-label" for="task-7">
            <td><?= $langs["registration"]["form"]["task_area"]["area_7"][$lang] ?? 'Név' ?>
          </label>
        </div>
      </div>
    </div>







    <div class="col-xs-12 mt-3">
      <div class="form-outline mb-4">
        <label class="form-label" for="programs"><b>
            <?= $langs["registration"]["form"]["informedBy"]["title"][$lang] ?? 'Név' ?>
          </b></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-1" value="option2">
          <label class="form-check-label" for="program-1">
            <?= $langs["registration"]["form"]["informedBy"]["info_1"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-2" value="option3">
          <label class="form-check-label" for="program-2">
            <?= $langs["registration"]["form"]["informedBy"]["info_2"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-3" value="option3">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["informedBy"]["info_3"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-3" value="option3">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["informedBy"]["info_4"][$lang] ?? 'Név' ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="programs" id="program-3" value="option3">
          <label class="form-check-label" for="program-3">
            <?= $langs["registration"]["form"]["informedBy"]["info_5"][$lang] ?? 'Név' ?>
          </label>
        </div>
      </div>
    </div>






    <div class="col-xs-12 mt-3 d-flex align-items-center justify-content-center">
      <div class="form-outline mb-4">
        <div class="form-check form-switch">
          <input class="form-check-input" style="font-size: 1.5rem;" type="checkbox" id="flexSwitchCheckDefault">

          <label class="form-check-label" for="flexSwitchCheckDefault">
            <?= $langs["registration"]["form"]["email_permission"][$lang] ?? 'Név' ?>
          </label>
        </div>
      </div>
    </div>
  </div>



  
  <div class="text-center">
    <button type="submit" class="btn btn-outline-success">Regisztráció</button>
  </div>
</form>