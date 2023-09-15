<link rel="stylesheet" href="/public/css/admin/volunteers.css?v=<?= time() ?>">

<?php
$volunteers = $params["volunteers"] ?? null;

?>

<div id="admin-volunteers" class="d-flex align-items-center justify-content-center flex-column">
  <?php if (!isset($volunteers) || count($volunteers) === 0) : ?>
    <div id="no-volunteers" class="text-center">
      <h1 class="mb-3">Jelenleg nincs egy önkéntes sem!</h1>
      <a href="/admin/volunteers/new" class="btn btn-lg btn-outline-primary">Önkéntes hozzáadása</a>
    </div>
  <?php else : ?>
    <h1 class="text-center mb-2">Önkéntesek</h1>
    <hr class="w-100 mb-5">
    <ul class="list-group list-group-light mt-5" id="volunteers-list">
      <?php foreach ($volunteers as $volunteer) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
          <div class="d-flex align-items-center">
            <img src="/public/assets/uploads/images/volunteers/<?= $volunteer["fileName"] ?>" alt="" style="width: 60px; height: 60px" class="rounded-circle" />
            <div class="ms-3">
              <p class="fw-bold mb-1"><?= $volunteer["name"] ?></p>
            </div>
          </div>
          <div>
            <a href="/admin/volunteers/update/<?= $volunteer["id"] ?>" class="btn m-2 btn-warning rounded-pill badge-success text-light"><i class="bi bi-arrow-clockwise"></i></a>
            <span class="btn m-2 btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#volunteerModal<?= $volunteer["id"] ?>"><i class="bi bi-trash"></i></span>
          </div>
        </li>

        <div class="modal fade" id="volunteerModal<?= $volunteer["id"] ?>" tabindex="-1" aria-labelledby="volunteerModalLabel" aria-hidden="true">
          <?php $current_volunteer = $volunteer["name"]; ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="volunteerModalLabel ">Figyelem!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_volunteer ?> </span>&nbsp; nevű önkéntest?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                <a href="/admin/volunteers/delete/<?= $volunteer["id"] ?>" class="btn btn-primary">Törlés</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>

    </ul>

    <?php if (count($volunteers) !== 3) : ?>
      <div class="text-center mt-5">
        <a href="/admin/volunteers/new" class="btn btn-outline-primary">Önkéntes hozzáadása</a>
      </div>
    <?php endif ?>
</div>
<?php endif ?>
</div>