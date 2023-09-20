<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$events = $params["events"];


?>


<div class="container mt-5 p-5 shadow r-border" style="min-height: 75vh">
  <div class="row">
    <h1 class="text-center mb-5">További eseményeink</h1>
    <?php foreach ($events as $event) : ?>
      <div class="card mt-4">
        <i class="card-header"><?= date("j", time() - $event["createdAt"])?> nappal ezelőtt</i>
        <div class="card-body">
          <h5 class="card-title"><?= $event[languageSwitcher("name")]?></h5>
          <p class="card-text"><?= $event[languageSwitcher("description")]?></p>
          <p class="card-text p-2 text-light bg-warning border border-warning">Regisztráció lejár: <?= $event["reg_end_date"]?></p>
          <a href="/event/<?= $event["eventId"]?>" class="btn btn-primary">Megtekintés</a>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>