<link rel="stylesheet" href="/public/css/user/event.css?v=<?php echo time() ?>">


<?php
$lang = $_COOKIE["lang"] ?? null;

$event = $params["event"];

$dates = $params["dates"];
$links = $params["links"];
$tasks = $params["tasks"];
?>

<div class="d-flex align-items-center justify-content-center" style="height: 91vh;" id="public-event">
  <div class="container py-5" style="background-color: white;">

    <div class="row">

      <div class="col-12 my-5">
        <a href="/">Vissza a főoldalra</a>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body text-center">
            <img src="<?= isset($event["fileName"]) && $event["fileName"] !== '' ? '/public/assets/uploads/images/events/' . $event["fileName"] : '/public/assets/icons/bear.png' ?>" alt="avatar" class="rounded-circle img-fluid shadow" style="height: 150px;width: 150px;">
            <h5 class="my-3"><?= $event["nameInHu"] ?></h5>
            <div>
              <p class="text-muted mb-3">Regisztráció vége: <?= $event["reg_end_date"] ?></p>
            </div>
            <div class="border p-3">
              <?php if (strtotime($event["end_date"]) < strtotime('today') || strtotime($event["reg_end_date"]) < strtotime('today')) : ?>
                <span class="badge p-3 bg-danger">Regisztráció lezárult</span>
              <?php else : ?>
                <a href="/event/register/<?= $event["eventId"] ?>" class="btn btn-outline-primary">Regisztráció</a>
                <button type="button" class="btn btn-outline-secondary ms-1">Üzenet küldése</button>
              <?php endif ?>
            </div>
            <br>
            <p class="text-muted mb-0"><?= $event[languageSwitcher("description")] ?></p>
          </div>
        </div>

      </div>

      <div class="col-lg-8 ">
        <div class="card mb-4">

          <div class="card-body">
            <p class="mb-4"><span class="text-primary font-italic me-1">Választható feladatok</span></p>
            <?php foreach ($tasks as $task) : ?>
              <div class="row">
                <div class="col-12">
                  <p class="mb-0"><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></p>
                  <hr>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="card mb-4">

          <div class="card-body">
            <p class="mb-1"><span class="text-primary font-italic me-1">Választható dátumok</span></p>

            <?php foreach ($dates as $date) : ?>
              <button type="button" class="btn btn-info text-light mt-3"><?= $date["date"] ?></button>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>