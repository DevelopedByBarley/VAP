<?php
$user = $params["user"];
$documents = $params["documents"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>

<div class="d-flex align-items-center flex-column justify-content-center vh-100 container">

  <div class="row d-flex align-items-center flex-column r-border p-3" id="user-documents">
    <div class="head p-1">
      <h1 class="text-center text-lg-start">Feltöltött dokumentumok</h1>
      <p class="text-center text-lg-start">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea tempora beatae eum rerum, facilis quibusdam ducimus voluptate vel officiis totam deserunt voluptatem dolorum, accusamus minus, omnis placeat corrupti corporis minima.</p>
    </div>

    <div class="row w-100 d-flex align-items-center justify-content-center" style="min-height: 30vh">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Típus</th>
            <th scope="col">Műveletek</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($documents as $index => $document) : ?>
            <?php $current_document = UPLOAD_DOCUMENTS["types"][$document["type"]][$lang] ?>
            <tr>
              <th scope="row"><?= $index + 1 ?></th>
              <td><?= $current_document ?></td>
              <td>
                <div class="btn-group">
                  <a href="/user/documents/update/<?= $document["id"] ?>" class="btn btn-warning rounded-pill badge-success text-light"><i class="bi bi-arrow-clockwise"></i></a>
                  <button class="btn 2 btn-danger mx-1 rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#documentModal<?= $document["id"] ?>"><i class="bi bi-trash"></i></button>
                </div>
              </td>
              <td><a href="/public/assets/uploads/documents/users/<?= $document["name"] ?>" class="btn btn-primary" download>Letöltés</a></td>
            </tr>

            <div class="modal fade" id="documentModal<?= $document["id"] ?>" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="documentModalLabel">Figyelem!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_document   ?> </span>&nbsp; nevű dokumentumot?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                    <a href="/user/documents/delete/<?= $document["id"] ?>" class="btn btn-primary">Törlés</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>

        </tbody>
      </table>
      <?php if (count($documents) !== 2) : ?>
        <div class="mt-5 text-center">
          <a href="/user/documents/new" class="btn btn-outline-primary">Dokumentum hozzáadása</a>
        </div>
      <?php endif ?>
    </div>
  </div>

</div>