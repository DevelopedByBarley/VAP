<?php
$events = $params["events"] ?? null;
?>

<div class="row">
  <?php if (!isset($events) || count($events) === 0) : ?>
    <div class="col-12">
      <div id="no-links" class="text-center">
        <h1 class="display-3 mb-3">Jelenleg nincs egy esemény sem!</h1>
        <a href="/admin/events/new" class="btn btn-lg btn-outline-primary">Esemény hozzáadása</a>
      </div>
    </div>
  <?php else : ?>

    <div class="col-12 ">
      <div class="text-center">
        <h1 class="display-5 mb-3 text-center">Események</h1>
      </div>
      <div class="row d-flex align-items-center justify-content-center">
        <?php foreach ($events as $event) : ?>
          <?php $current_event = $event["nameInHu"]; ?>
          <div class="card event-card m-1" style="width: 18rem;">
            <img src="/public/assets/uploads/images/events/<?= $event["fileName"] ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?= $event["nameInHu"] ?></h5>
              <p class="card-text"><?= $event["date"] ?></p>
              <a href="#" class="btn btn-primary rounded-pill"><i class="bi bi-eye"></i></a>
              <a href="/admin/events/update/<?= $event["eventId"] ?>" class="btn btn-warning rounded-pill text-light"><i class="bi bi-arrow-clockwise"></i></a>
              <span class="btn btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#partnerModal<?= $event["eventId"] ?>"><i class="bi bi-trash"></i></span>
            </div>
          </div>

          <div class="modal fade" id="partnerModal<?= $event["eventId"] ?>" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="partnerModalLabel">Figyelem!</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_event ?> </span>&nbsp; nevű eseményt?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                  <a href="/admin/events/delete/<?= $event["eventId"] ?>" class="btn btn-primary">Törlés</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      </div>
      <div class="text-center">
        <a href="/admin/events/new" class="btn btn-outline-primary mt-5">Esemény hozzáadása</a>
      </div>
    </div>
  <?php endif ?>
</div>