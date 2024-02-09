<?php
$event = $params["event"];
$dates = $params["dates"];
$tasks = $params["tasks"];
$links = $params["links"];
$subscriptions = $params["subscriptions"];
$countOfRegistrations = (int)$params["countOfRegistrations"];
$countOfUserByEmailStates = $params["countOfUserByEmailStates"];
$anyAccepted = $params["anyAccepted"];
$bgImageUrl = isset($event["fileName"]) && $event["fileName"] !== '' ? '/public/assets/uploads/images/events/' . $event["fileName"] : '/public/assets/icons/bear.png';




?>

<section style="background-color: #eee; margin-top: 100px; width: 95%; margin: 0 auto; border-radius: 12px mb-5" class="shadow">
  <div class="container py-5">

    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow">
          <div class="card-body text-center d-flex align-items-center justify-content-center flex-column">

            <div class="rounded-circle shadow" style="width: 150px; height: 150px; background: url('<?php echo $bgImageUrl; ?>') center center/cover no-repeat;"></div>
            <h5 class="my-3"><?= $event["nameInHu"] ?></h5>
            <div class="mt-3 mb-3">
              <button class="btn <?= (int)$event["isPublic"] === 1 ? 'bg-success' : 'bg-danger' ?> text-light" checked>
                <b> <?= (int)$event["isPublic"] === 1 ? 'Publikus' : 'Privát' ?></b>
              </button>
            </div>


            <?php if (strtotime($event["end_date"]) < strtotime('today')) : ?>
              <button class="btn btn-danger">Lezárult</button>
            <?php endif ?>
            <div class="bg-secondary p-3">
              <p class="text-light mb-1">Esemény kezdete: <?= $event["date"] ?></p>
              <p class="text-light mb-1">Esemény vége: <?= $event["end_date"] ?></p>
            </div>
            <div class="border p-3">
              <b class="text-muted">Regisztráltak száma: <?= $countOfRegistrations ?></b>
              <br>
              <a href="/admin/event/subscriptions/<?= $event["eventId"] ?>" class="btn btn-primary mt-2">Áttekintés</a>
              <a href="/admin/event/email/<?= $event["eventId"] ?>" class="btn btn-secondary mt-2 <?= $countOfRegistrations === 0 ? 'disabled' : '' ?>">Email küldése</a>
              <a href="/admin/subscription/export-subscribers?id=<?= $event["eventId"] ?>" class="btn btn-secondary mt-2 <?= $countOfRegistrations === 0 || !$anyAccepted ? 'disabled' : '' ?>">Excel exportálása</a>

              <p class="mt-3">Az excelbe csak az elfogadott regisztrációk lesznek benne, ha nincs elfogadott regisztráció sem, az exportálás nem lehetséges </p>
            </div>

            <div class="btn-group text-center mb-3 mt-3">
              <a class="btn btn-outline-primary" href="/admin/event/state/<?= $event["eventId"] ?>?state=<?= (int)$event["isPublic"] === 1 ? '0' : '1' ?>"><?= (int)$event["isPublic"] === 1 ? 'Legyen Privát' : 'Legyen Publikus' ?></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-8">

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

        <div class="card mb-4">

          <div class="card-body">
            <p class="mb-4"><span class="text-primary font-italic me-1">Választható feladatok</span></p>
            <?php foreach ($tasks as $task_data) : ?>
              <div class="row">
                <div class="col-12">
                  <p class="mb-0"><?= TASK_AREAS["areas"][$task_data["task"]]["Hu"] ?></p>
                  <hr>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <p class="mb-1"><span class="text-primary font-italic me-1">Választható Dátumok</span></p>
            <div class="row">
              <div class="col-sm-12">
                <?php foreach ($dates as $date) : ?>
                  <button type="button" class="btn btn-primary mt-3"><?= $date["date"] ?></button>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow mt-2">
          <div class="card-body">
            <p class="mb-1"><span class="text-primary font-italic me-1">Hozzátartozó linkek</span></p>

            <div class="row">
              <div class="col-sm-12 mt-3">
                <?php foreach ($links as $link) : ?>
                  <div class="row">
                    <div class="col-12">
                      <a href="<?= $link["link"] ?>" class="mb-0 text-info"><?= $link["link"] ?></a>
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