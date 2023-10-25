<link rel="stylesheet" href="/public/css/user/event.css?v=<?php echo time() ?>">


<?php
$lang = $_COOKIE["lang"] ?? null;

$event = $params["event"] ?? null;

$dates = $params["dates"] ?? null;
$links = $params["links"] ?? null;
$tasks = $params["tasks"] ?? null;
$isRegistered = $params["isRegistered"] ?? null;
?>

<div class="container-fluid mt-b" style="position: relative; z-index: 0;">
  <div class="row">
    <div class="col-12 m-0 p-0" style='min-height: 70vh; background: url("/public/assets/uploads/images/events/<?php echo $event["fileName"]; ?>") center center/cover;' id="event-fixed-bg">
      <div class="text-light text-center h-100 w-100 d-flex align-items-center justify-content-center flex-column" style="background-color:hsla(176, 0%, 0%, 0.6)">
        <h1 class="text-light"><?= $event["nameInHu"] ?></h1>
        <h3 class="text-light"><?= $event["date"] ?> - <?= $event["end_date"] ?></h3>
        <p class="mb-5"><i class="text-light">Üdvözöljük a <?= $event["nameInHu"] ?> esemény oldalán!</i></p>
        <p class="text-light">Görges tovább a részletekért és a jelentkezésért</p>

      </div>
    </div>
  </div>
  <div class="row d-flex justify-content-center align-items-center mt-3">

    <?php foreach ($dates as $date) : ?>
      <?php
      $dateTime = new DateTime($date["date"]);
      $year = $dateTime->format('Y');
      $month = $dateTime->format('n');
      $day = $dateTime->format('d');
      ?>
      <!--
           <div class="col-6 col-lg-1 bg-dark py-4 text-light d-flex justify-content-center align-items-center">
             <i class="bi bi-calendar2-week-fill text-light" style="font-size: 2.2rem;"></i>
          </div>
         -->
      <div class="col-4 col-lg-1 m-1 py-3 px-5 pr-color text-light d-flex justify-content-center align-items-center flex-column">
        <h1 class="text-light"><?= $day ?></h1>
        <h6 class="text-light" style="margin-top: -10px;"><?= MONTHS_IN_LANGUAGE[$month][$lang] ?></h6>
      </div>
    <?php endforeach ?>

  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12 text-center my-5 d-flex justify-content-center flex-column reveal" style="min-height: 30vh;">
      <h2 class="text-uppercase text-secondary mb-4"><?= $event["nameInHu"] ?></h2>
      <p class="text-secondary"><?= $event["descriptionInEn"] ?></p>
    </div>
  </div>
  <div class="row">
    <div class="col-12 text-center text-lg-end offset-lg-2 col-lg-10 my-5 d-flex justify-content-center flex-column" style="min-height: 30vh;">
      <h2 class="text-uppercase reveal text-secondary">Választható feladatok</h2>
      <p class="reveal text-secondary"><i>Válassza ki jelentkezésnél hogy mely feladatkörök érdeklik önt a legjobban!</i></p>
      <div class="row mt-4">
        <?php foreach ($tasks as $task) : ?>
          <div class="col-12 reveal">
            <p class="mb-0 text-secondary "><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></p>
            <hr>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-12 text-center text-lg-start col-lg-10 my-5 d-flex justify-content-center flex-column" style="min-height: 30vh;">
      <h2 class="text-uppercase reveal text-secondary">Kapcsolódó online felületek</h2>
      <p class="reveal text-secondary"><i>Tekintse meg az eseményhez kapcsolódó online felületeinket további információkért!</i></p>
      <div class="row mt-4">
        <?php foreach ($links as $link) : ?>
          <div class="col-12 reveal text-secondary">
            <a href="<?= $link["link"] ?>" class="mb-0"><?= $link["link"] ?></a>
            <hr>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-center d-flex align-items-center justify-content-center flex-column" style="min-height: 30vh;">
      <h1 class="reveal text-secondary">Mi következik a regisztráció után?</h1>
      <p class="reveal text-secondary">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente et recusandae repudiandae, laudantium saepe fugiat. Doloremque, excepturi possimus aperiam saepe velit quibusdam iusto quisquam consectetur, omnis animi, illum dicta enim!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio modi amet illo, pariatur consequuntur autem rerum vitae, expedita voluptate quo doloremque facere suscipit sed repellendus similique, id quasi incidunt numquam.
      </p>
    </div>
  </div>


  <div class="row mt-5 reveal">
    <div class="col-12">
      <?php if ($isRegistered) : ?>
        <h1 class="text-center text-secondary">Erre az eseményre már regisztrált!</h1>
      <?php else : ?>
        <h1 class="text-center text-secondary">Tovább a regisztrációhoz.</h1>
        <p class="text-secondary text-center"><i>Lépj tovább a regisztrációs felületre vagy kérdezz tőlünk bátran az "Üzenet" küldése gomb segítségével!</i></p>
      <?php endif ?>

    </div>
    <div class="col-12 text-center py-3" style="min-height: 300px;;">
      <?php if (strtotime($event["end_date"]) < strtotime('today') || strtotime($event["reg_end_date"]) < strtotime('today')) : ?>
        <span class="badge p-3 bg-danger">Regisztráció lezárult</span>
      <?php else : ?>
        <?= $isRegistered ? '' : "<a href=\"/event/subscribe/{$event['eventId']}\" class=\"btn secondary-btn\">Regisztráció</a>" ?>
        <a href="mailto:hello@artnesz.hu" class="btn primary-btn ms-1">Üzenet küldése</a>
      <?php endif ?>
    </div>
  </div>

</div>