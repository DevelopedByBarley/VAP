<?php
$partners = $params["partners"] ?? null;
?>

<div class="container">
  <div class="row">
    <div class="col-12 my-5">
      <h1 class="text-center">TOVÁBBI PARTNEREINK</h1>
    </div>
    <?php foreach ($partners as $partner) : ?>
      <a href="<?= $partner["link"] ?? '' ?>" class="co-12 col-sm-3 mb-1 p-1 text-decoration-none text-dark">
        <div class="card p-3" style="width: 100%;">
          <div class="d-flex align-items-center justify-content-center">
            <div style="background: url('/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>') center center/cover; height: 100px; width: 100px;" class="card-img-top"></div>
          </div>
          <div class="card-body">
            <b><?= $partner["name"] ?></b>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
          </div>
        </div>
      </a>
    <?php endforeach ?>
  </div>
</div>