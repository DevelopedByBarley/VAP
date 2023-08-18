<?php
$event = $params["event"];
$dates = $params["dates"];
$tasks = $params["tasks"];
$user = $params["user"];

$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

$langs = LANGS;
?>


<div class="row">
  <div class="col-xs-12">
    <form action="">
      <div class="btn-group">
        <?php foreach ($dates as $index => $date) : ?>
          <input type="checkbox" class="btn-check" id="date-<?= $index ?>" autocomplete="off">
          <label class="btn btn-outline-primary" for="date-<?= $index ?>"><?= $date["date"] ?></label><br>
        <?php endforeach ?>
      </div>

      <?php foreach ($tasks as $index => $task) : ?>
        <div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="task<?= $index ?>" value="<?= $index ?>" name="tasks[]">
            <label class="form-check-label" id="task<?= $index ?>"><?= $langs["registration"]["form"]["task_area"]["areas"][$task["task"]][$lang] ?></label>
          </div>
        </div>
      <?php endforeach ?>



      <div>
        <button type="submit" class="btn btn-outline-primary">Regisztráció</button>
      </div>

    </form>
  </div>
</div>