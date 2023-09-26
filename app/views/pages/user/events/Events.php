<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$events = $params["events"];


?>


<div class="d-flex align-items-center justify-content-center pr-color" style="min-height: 95vh;">
  <div class="container p-5 shadow r-border bg-light" style="min-height: 75vh">
    <?php if (count($events) === 0) : ?>
      <div class="row">
        <h1 class="text-center mb-5">Jelenleg nincs egyetlen eseményünk sem!</h1>
      </div>
    <?php else : ?>
      <div class="row">
        <h1 class="text-center mb-5">További eseményeink</h1>
        <?php foreach ($events as $event) : ?>
          <div class="card mt-4 shadow pt-3">
            <i class="card-header"><?= date("j", time() - $event["createdAt"]) ?> nappal ezelőtt</i>
            <div class="card-body">
              <h5 class="card-title"><?= $event[languageSwitcher("name")] ?></h5>
              <p class="card-text"><?= $event[languageSwitcher("description")] ?></p>
              <p class="card-text p-2 text-light bg-warning border border-warning">Regisztráció lejár: <?= $event["reg_end_date"] ?></p>
              <a href="/event/<?= $event["eventId"] ?>" class="btn btn-primary">Megtekintés</a>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    <?php endif ?>
  </div>
</div>