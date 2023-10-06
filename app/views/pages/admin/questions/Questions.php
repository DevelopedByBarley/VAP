<link rel="stylesheet" href="/public/css/admin/questions.css?v=<?= time() ?>">


<?php
$questions = $params["questions"] ?? null;
?>

<div class="container">
  <div class="row">
    <div class="col-12 vh-100 d-flex align-items-center justify-content-center flex-column">
      <h1 class="mb-5">Gyakori kérdések</h1>
      <div class="table-responsive w-100">
        <table class="table">
          <thead class="bg-dark text-light">
            <tr>
              <th>Kérdés</th>
              <th>Műveletek</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($questions as $index => $question) : ?>

              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="ms-3">
                      <p class="fw-bold mb-1"> <?= $question["questionInHu"] ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="ms-3">
                      <div class="btn-group" role="group">
                        <a href="/admin/questions/update/<?= $question["q_id"] ?>" class="btn btn-dark rounded-pill badge-success text-light" style="margin-left: 1rem;"><i class="bi bi-arrow-clockwise"></i></a>
                        <span class="btn btn-danger rounded-pill badge-success" style="margin-left: .5rem; margin-right: .5rem;" data-bs-toggle="modal" data-bs-target="#questionModal<?= $question["q_id"] ?>"><i class="bi bi-trash"></i></span>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>




              <div class="modal fade" id="questionModal<?= $question["q_id"] ?>" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
                <?php $current_question = $question["questionInHu"]; ?>
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="questionModalLabel">Figyelem!</h5>
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
          </tbody>
        </table>
      </div>
      <div class="text-center mt-5">
        <a href="/admin/questions/new" class="btn btn-outline-dark">Kérdés hozzáadása</a>
      </div>
    </div>
  </div>
</div>