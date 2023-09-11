<?php
$event = $params["event"];
$dates = $params["dates"];
$tasks = $params["tasks"];
$links = $params["links"];
$subscriptions = $params["subscriptions"];
$countOfRegistrations = (int)$params["countOfRegistrations"];
$countOfUserByEmailStates = $params["countOfUserByEmailStates"];

?>

<section style="background-color: #eee; margin-top: 100px; width: 95%; margin: 0 auto; border-radius: 12px mb-5" class="shadow">
  <div class="container py-5">

    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow">
          <div class="card-body text-center">
            <img src="<?= isset($event["fileName"]) && $event["fileName"] !== '' ? '/public/assets/uploads/images/events/' . $event["fileName"] : '/public/assets/icons/bear.png' ?>" alt="avatar" class="rounded-circle img-fluid shadow" style="height: 150px;width: 150px;">
            <h5 class="my-3"><?= $event["nameInHu"] ?></h5>
            <?php if (strtotime($event["end_date"]) < strtotime('today')) : ?>
              <button class="btn btn-danger">Lezárult</button>
            <?php endif ?>
            <div>
              <p class="text-muted mb-1"><?= $event["date"] ?></p>
              <p class="text-muted mb-1"><?= $event["end_date"] ?></p>
            </div>
            <div class="border p-3">
              <b class="text-muted">Regisztráltak száma: <?= $countOfRegistrations ?></b>
              <br>
              <a href="/admin/event/subscriptions/<?= $event["eventId"] ?>" class="btn btn-outline-secondary mt-2">Áttekintés</a>
              <a href="/admin/event/email/<?= $event["eventId"] ?>" class="btn btn-outline-secondary mt-2">Email küldése</a>

            </div>
          </div>
        </div>


        <div class="card mb-4 shadow">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Leirás</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0"><?= $event["descriptionInHu"] ?></p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-8">
        <div class="card mb-4">

          <div class="card-body">
            <p class="mb-4"><span class="text-primary font-italic me-1">Választható feladatok</span></p>
            <?php foreach ($tasks as $task) : ?>
              <div class="row">
                <div class="col-12">
                  <p class="mb-0"><?= TASK_AREAS["areas"][$task["task"]]["Hu"] ?></p>
                  <hr>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>

        <div class="card shadow">
          <div class="card-body text-center">
            <div class="row">
              <div class="col-sm-12">
                <p class="mb-0">Választható dátumok</p>
              </div>
              <div class="col-sm-12 mt-3">
                <?php foreach ($dates as $date) : ?>
                  <button type="button" class="btn btn-primary mt-3"><?= $date["date"] ?></button>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow mt-2">
          <div class="card-body text-center">
            <div class="row">
              <div class="col-sm-12">
                <p class="mb-0">Hozzáadott linkek</p>
              </div>
              <div class="col-sm-12 mt-3">
                <?php foreach ($links as $link) : ?>
                  <div class="row">
                    <div class="col-12">
                      <a href="<?= $link["link"] ?>" class="mb-0"><?= $link["link"] ?></a>
                      <hr>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>