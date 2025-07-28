<link rel="stylesheet" href="/public/css/user/event.css?v=<?php echo time() ?>">


<?php
$lang = $_COOKIE["lang"] ?? null;

$event = $params["event"] ?? null;

$dates = $params["dates"] ?? null;
$links = $params["links"] ?? null;
$tasks = $params["tasks"] ?? null;
$isRegistered = $params["isRegistered"] ?? null;

?>



<div class="event-hero">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 d-flex justify-content-center align-items-center mt-5">
        <img src="/public/assets/uploads/images/events/<?php echo $event["fileName"] ?>" 
             class="event-image" 
             alt="<?= htmlspecialchars($event["nameInHu"]) ?>">
      </div>
    </div>
    
    <div class="row d-flex justify-content-center align-items-center mt-3">
      <div class="col-12">
        <h2 class="event-title text-center"><?= $event["nameInHu"] ?></h2>
      </div>
      
      <div class="event-date-container">
        <?php foreach ($dates as $date) : ?>
          <?php
          $dateTime = new DateTime($date["date"]);
          $year = $dateTime->format('Y');
          $month = $dateTime->format('n');
          $day = $dateTime->format('d');
          ?>
          <div class="event-date-card">
            <h1 class="event-date-day"><?= $day ?></h1>
            <h6 class="event-date-month"><?= MONTHS_IN_LANGUAGE[$month][$lang] ?></h6>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="event-description text-center reveal">
        <p><?= $event[languageSwitcher("description")] ?></p>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12 text-center text-lg-end offset-lg-2 col-lg-10 my-5">
      <div class="event-section">
        <h2 class="event-section-title reveal"><?= EVENT["tasks"]["title"][$lang] ?? 'HIBA' ?></h2>
        <p class="event-section-description reveal"><i><?= EVENT["tasks"]["description"][$lang] ?? 'HIBA' ?></i></p>
        <div class="row mt-4">
          <?php foreach ($tasks as $task) : ?>
            <div class="col-12 reveal">
              <div class="event-task-item">
                <p class="mb-0"><?= TASK_AREAS["areas"][$task["task"]][$lang] ?></p>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-center text-lg-start col-lg-10 my-5">
      <div class="event-section">
        <h2 class="event-section-title reveal"><?= EVENT["links"]["title"][$lang] ?? 'HIBA' ?></h2>
        <p class="event-section-description reveal"><i><?= EVENT["links"]["description"][$lang] ?? 'HIBA' ?></i></p>
        <div class="row mt-4">
          <?php foreach ($links as $link) : ?>
            <div class="col-12 reveal">
              <div class="event-link-item">
                <a href="<?= $link["link"] ?>" class="mb-0"><?= $link["link"] ?></a>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-center d-flex align-items-center justify-content-center flex-column" style="min-height: 30vh;">
      <div class="event-section">
        <h1 class="event-section-title reveal"><?= EVENT["after_registration"]["title"][$lang] ?? 'HIBA' ?></h1>
        <p class="reveal">
          <?= EVENT["after_registration"]["description"][$lang] ?? 'HIBA' ?>
        </p>
      </div>
    </div>
  </div>

  <div class="row mt-5 reveal">
    <div class="col-12">
      <?php if ($isRegistered) : ?>
        <h1 class="text-center"><?= EVENT['registrated'][$lang] ?? 'HIBA' ?></h1>
      <?php else : ?>
        <h1 class="text-center"><?= EVENT["go_to_reg"]["title"][$lang] ?? 'HIBA' ?></h1>
      <?php endif ?>
    </div>
    <div class="col-12 text-center py-3" style="min-height: 200px;">
      <?php if (strtotime($event["end_date"]) < strtotime('today') || strtotime($event["reg_end_date"]) < strtotime('today')) : ?>
        <span class="event-status-badge event-status-closed">Regisztráció lezárult</span>
      <?php else : ?>
        <?php if (!isset($_SESSION["userId"])) : ?>
          <button type="button" class="event-btn event-btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
            <?= EVENT["registration"][$lang] ?? 'HIBA' ?>
          </button>
        <?php else : ?>
          <?= $isRegistered ? '' : "<a href=\"/event/subscribe/{$event['slug']}\" class=\"event-btn event-btn-primary\">" . (EVENT['registration'][$lang] ?? 'HIBA') . "</a>" ?>
        <?php endif ?>

        <a href="mailto:developedbybarley@gmail.com" class="event-btn event-btn-secondary ms-1"><?= EVENT['send_message'][$lang] ?? 'HIBA' ?></a>
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
          <h5 class="modal-title" id="exampleModalLongTitle"><?= EVENT["modal"]["title"][$lang] ?? 'HIBA' ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?= EVENT["modal"]["desc"][$lang] ?? 'HIBA' ?>
        </div>
        <div class="modal-footer">
          <a href="/user/registration" class="btn btn-primary event-btn event-btn-primary"><?= EVENT["modal"]["accept"][$lang] ?? 'HIBA' ?></a>
          <?= $isRegistered ? '' : "<a href=\"/event/subscribe/{$event['slug']}\" class=\"btn btn-secondary event-btn event-btn-secondary\">" . (EVENT['modal']['decline'][$lang] ?? 'HIBA') . "</a>" ?>
        </div>
      </div>
    </div>
  </div>

<?php endif ?>