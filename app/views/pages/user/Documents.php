<?php
$user = $params["user"];
$documents = $params["documents"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>


<div class="col-xs-12 d-flex align-items-center flex-column" id="user-documents">
  <div class="head p-3 text-center">
    <h1 class="text-center">Feltöltött dokumentumok</h1>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea tempora beatae eum rerum, facilis quibusdam ducimus voluptate vel officiis totam deserunt voluptatem dolorum, accusamus minus, omnis placeat corrupti corporis minima.</p>
  </div>

  <div class="row mt-5 w-100">
    <?php foreach ($documents as $document) : ?>
      <?php $current_document =  $langs["registration"]["form"]["upload_documents"][$document["type"]][$lang] ?>
      <div class="col-xs-12 col-sm-4 mt-3 m-4 p-4 bg-light rounded shadow">
        <h5><a href="/public/assets/uploads/documents/users/<?= $document["name"] ?>" download class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" style="font-size: 1.7rem;"><?= $langs["registration"]["form"]["upload_documents"][$document["type"]][$lang] ?> <i class=" m-2 bi bi-cloud-arrow-down-fill"></i> </a></h5>
        <p><?= $document["originalFileName"] ?? '' ?></p>
        <hr>
        <div class="btn-group">
          <a href="/user/documents/update/<?= $document["id"] ?>" class="btn m-2 btn-warning rounded-pill badge-success text-light"><i class="bi bi-arrow-clockwise"></i></a>
          <button class="btn m-2 btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#documentModal<?= $document["id"] ?>"><i class="bi bi-trash"></i></button>
        </div>
      </div>
      
      
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
      <?php if (count($documents) !== 2) : ?>
        <div class="mt-3 text-center">
          <a href="/user/documents/new" class="btn btn-outline-primary">Dokumentum hozzáadása</a>
        </div>
      <?php endif ?>
    </div>
</div>