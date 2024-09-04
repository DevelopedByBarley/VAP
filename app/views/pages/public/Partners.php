<?php
$partners = $params["partners"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
?>

<div class="container">
  <div class="row">
    <div class="col-12 my-5">
      <h1 class="text-center mt-5"><?= CONTENT["partners"]["other_partners"][$lang] ?? 'HIBA' ?></h1>
    </div>
    <?php foreach ($partners as $partner) : ?>
      <a href="<?= $partner["link"] ?? '' ?>" class="co-12 col-sm-3 mb-1 p-1 text-decoration-none text-dark mt-3 ">
        <div class="card p-3 border-0 shadow" style="width: 100%; min-height: 450px">
          <div class="d-flex align-items-center justify-content-center">
            <div style="background: url('/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>') center center/cover; height: 100px; width: 100px;" class="card-img-top"></div>
          </div>
          <div class="card-body">
            <h4 class="my-3"><?= $partner["name"] ?></h4>
            <p class="card-text">
            <p class="card-text"><?= $partner[languageSwitcher("description")] ?></p>
            </p>
            <div>
              <?php
              $sup =  CONTENT["partners"]["sup_partners"]["short"][$lang] ?? '';
              $coop =  CONTENT["partners"]["coop_partners"]["short"][$lang] ?? '';
              ?>
              <?= $partner["type"] === "support" ? " <span class='badge bg-success p-2 mt-2'>$sup</span>" :  "<span class='badge bg-info p-2 mt-2'>$coop</span>" ?>
            </div>
          </div>
        </div>
      </a>
    <?php endforeach ?>
  </div>
</div>