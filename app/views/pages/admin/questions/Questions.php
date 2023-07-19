<?php
$questions = $params["questions"] ?? null;
?>

<div id="admin-partners" class="d-flex align-items-center justify-content-center flex-column">
  <?php if (!isset($questions) || count($questions) === 0) : ?>
    <div id="no-partners" class="text-center">
      <h1 class="display-3 mb-3">Jelenleg nincs egy kérdés sem!</h1>
      <a href="/admin/questions/new" class="btn btn-lg btn-outline-primary">Kérdés hozzáadása</a>
    </div>
  <?php else : ?>
    <h1 class="text-center display-5" style="margin-top: 100px;">Gyakori kérdések</h1>
    <hr class="mb-5 w-100">
    <div class="accordion w-100" id="questions-list">
      <?php foreach ($questions as $index => $question) : ?>
        <div class="accordion-item">

          <h2 class="accordion-header" id="headingOne">

            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $question["q_id"] ?>" aria-expanded="true" aria-controls="collapseOne">
              <b><?= $question["questionInHu"] ?></b>
            </button>
          </h2>
          <div id="collapse<?= $question["q_id"] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body d-flex justify-content-between align-items-center">
              <?= $question["answerInHu"] ?>
              <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/admin/questions/update/<?= $question["q_id"] ?>" class="btn btn-warning rounded-pill badge-success text-light" style="margin-left: 1rem;"><i class="bi bi-arrow-clockwise"></i></a>
                <span class="btn btn-danger rounded-pill badge-success" style="margin-left: .5rem; margin-right: .5rem;" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $question["q_id"] ?>"><i class="bi bi-trash"></i></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="exampleModal<?= $question["q_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <?php $current_question = $question["questionInHu"]; ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Figyelem!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_question ?> </span>&nbsp; kérdést?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                <a href="/admin/questions/delete/<?= $question["q_id"] ?>" class="btn btn-primary">Törlés</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
    <div class="text-center mt-5">
      <a href="/admin/questions/new" class="btn btn-outline-primary">Kérdés hozzáadása</a>
    </div>


</div>
<?php endif ?>
</div>