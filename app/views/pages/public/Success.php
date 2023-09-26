<div class="container-fluid pr-color">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center flex-column" style="min-height: 92vh;">
      <div class="col-12 col-lg-6 text-center d-flex align-items-center justify-content-center flex-column shadow r-border bg-light" style="min-height: 50vh;">
        <img src="/public/assets/icons/success.png" style="height: 100px; width: 100px;" />
        <h1 class="mt-5"> <?= $params["title"] ?></h1>
        <small><?= $params["message"] ?></small>
        <a href="<?= $params["path"] ?>" class="btn pr-color text-light mt-3"><?= $params["button_message"] ?></a>
      </div>
    </div>
  </div>
</div>