<link rel="stylesheet" href="/public/css/user/event.css?v=<?php echo time() ?>">


<?php
$lang = $_COOKIE["lang"] ?? null;

$event = $params["event"] ?? null;

$dates = $params["dates"] ?? null;
$links = $params["links"] ?? null;
$tasks = $params["tasks"] ?? null;
$isRegistered = $params["isRegistered"] ?? null;

?>
<div class="container-fluid mt-b" style="position: relative; z-index: 0; margin-top: 0;">
  <div class="row">
    <div class="col-12 d-none d-xxl-block m-0 p-0" style='min-height: 70vh; background: url("/public/assets/uploads/images/events/<?php echo $event["fileName"]; ?>") center center/cover;' id="event-fixed-bg">
    </div>
    <div class="col-12 d-xxl-none m-0 p-0 mt-4">
      <img src="/public/assets/uploads/images/events/<?php echo $event["fileName"] ?>" class="img-fluid" alt="">
    </div>
  </div>
  <div class="row d-flex justify-content-center align-items-center mt-3">
    <div class="col-12">
      <h2 class="text-uppercase mb-4 text-center mt-5 mb-2 title"><?= $event["nameInHu"] ?></h2>
    </div>
    <span>
      <?php foreach ($dates as $date) : ?>
        <?php
        $dateTime = new DateTime($date["date"]);
        $year = $dateTime->format('Y');
        $month = $dateTime->format('n');
        $day = $dateTime->format('d');
        ?>
    </span>

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
    <div class="col-12 text-center mb-5 mt-3 d-flex justify-content-center flex-column reveal">
      <p><?= $event[languageSwitcher("description")] ?></p>
    </div>
  </div>
  <div class="row">
    <div class="col-12 text-center text-lg-end offset-lg-2 col-lg-10 my-5 d-flex justify-content-center flex-column" style="min-height: 30vh;">
      <h2 class="text-uppercase reveal"><?= EVENT["tasks"]["title"][$lang] ?? 'HIBA' ?></h2>
      <p class="reveal"><i><?= EVENT["tasks"]["description"][$lang] ?? 'HIBA' ?></i></p>
      <div class="row mt-4">
        <?php foreach ($tasks as $task) : ?>
          <div class="col-12 reveal">
            <p class="mb-0"><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></p>
            <hr>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-12 text-center text-lg-start col-lg-10 my-5 d-flex justify-content-center flex-column" style="min-height: 30vh;">
      <h2 class="text-uppercase reveal"><?= EVENT["links"]["title"][$lang] ?? 'HIBA' ?></h2>
      <p class="reveal"><i><?= EVENT["links"]["description"][$lang] ?? 'HIBA' ?></i></p>
      <div class="row mt-4">
        <?php foreach ($links as $link) : ?>
          <div class="col-12 reveal">
            <a href="<?= $link["link"] ?>" class="mb-0"><?= $link["link"] ?></a>
            <hr>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-center d-flex align-items-center justify-content-center flex-column" style="min-height: 30vh;">
      <h1 class="reveal"><?= EVENT["after_registration"]["title"][$lang] ?? 'HIBA' ?></h1>
      <p class="reveal">
        <?= EVENT["after_registration"]["description"][$lang] ?? 'HIBA' ?>
      </p>
    </div>
  </div>


  <div class="row mt-5 reveal">
    <div class="col-12">
      <?php if ($isRegistered) : ?>
        <h1 class="text-center"><?= EVENT['registrated'][$lang] ?? 'HIBA' ?></h1>
      <?php else : ?>
        <h1 class="text-center"><?= EVENT["go_to_reg"]["title"][$lang] ?? 'HIBA' ?></h1>
        <p class="text-center"><i><?= EVENT["go_to_reg"]["description"][$lang] ?? 'HIBA' ?></i></p>
      <?php endif ?>

    </div>
    <div class="col-12 text-center py-3" style="min-height: 200px;;">
      <?php if (strtotime($event["end_date"]) < strtotime('today') || strtotime($event["reg_end_date"]) < strtotime('today')) : ?>
        <span class="badge p-3 bg-danger">Regisztráció lezárult</span>
      <?php else : ?>

        <?php if (!isset($_SESSION["userId"])) : ?>
          <button type="button" class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
            <?= EVENT["registration"][$lang] ?? 'HIBA' ?>
          </button>
        <?php else : ?>
          <?= $isRegistered ? '' : "<a href=\"/event/subscribe/{$event['slug']}\" class=\"btn primary-btn\">" . (EVENT['registration'][$lang] ?? 'HIBA') . "</a>" ?>
        <?php endif ?>






        <a href="mailto:developedbybarley@gmail.com" class="btn secondary-btn ms-1"><?= EVENT['send_message'][$lang] ?? 'HIBA' ?></a>

      <?php endif ?>
    </div>
  </div>

</div>





<?php if (!$isRegistered) : ?>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"> <?= EVENT["modal"]["title"][$lang] ?? 'HIBA' ?></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= EVENT["modal"]["desc"][$lang] ?? 'HIBA' ?>
        </div>
        <div class="modal-footer">
          <a href="/user/registration" class="btn btn-primary"><?= EVENT["modal"]["accept"][$lang] ?? 'HIBA' ?></button>
            <?= $isRegistered ? '' : "<a href=\"/event/subscribe/{$event['slug']}\" class=\"btn btn-secondary\">" . (EVENT['modal']['decline'][$lang] ?? 'HIBA') . "</a>" ?>
        </div>
      </div>
    </div>
  </div>

<?php endif ?>