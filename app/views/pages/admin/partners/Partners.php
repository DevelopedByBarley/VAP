<?php
$partners = $params["partners"] ?? null;

?>

<div id="admin-partners" class="d-flex align-items-center justify-content-center flex-column">
  <?php if (!isset($partners) || count($partners) === 0) : ?>
    <div id="no-partners" class="text-center">
      <h1 class="display-3 mb-3">Jelenleg nincs egy partner sem!</h1>
      <a href="/admin/partners/new" class="btn btn-lg btn-outline-primary">Partner hozzáadása</a>
    </div>
  <?php else : ?>
    <h1 class="text-center display-4 mb-2">Partnerek listája</h1>
    <ul class="list-group list-group-light mt-5" id="partners-list">
      <?php foreach ($partners as $partner) : ?>
       <!-- <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
          <div class="d-flex align-items-center">
            <img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" alt="" style="width: 60px; height: 60px" class="rounded-circle" />
            <div class="ms-3">
              <p class="fw-bold mb-1"><?= $partner["name"] ?></p>
            </div>
          </div>
          <div>
            <a href="/admin/partners/update/<?= $partner["id"] ?>" class="btn m-2 btn-warning rounded-pill badge-success text-light"><i class="bi bi-arrow-clockwise"></i></a>
            <span class="btn m-2 btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $partner["id"] ?>"><i class="bi bi-trash"></i></span>
          </div>
        </li>

        <div class="modal fade" id="exampleModal<?= $partners["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <?php $current_partner = $partner["name"]; ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Figyelem!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_partner ?> </span>&nbsp; nevű önkéntest?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                <a href="/admin/partners/delete/<?= $partner["id"] ?>" class="btn btn-primary">Törlés</a>
              </div>
            </div>
          </div>
        </div> -->
      <?php endforeach ?>

    </ul>

    
      <div class="text-center mt-5">
        <a href="/admin/partners/new" class="btn btn-outline-primary">Partner hozzáadása</a>
      </div>
</div>
<?php endif ?>
</div>