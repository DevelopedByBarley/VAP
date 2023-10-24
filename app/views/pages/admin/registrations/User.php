<?php
$user = $params["user"];
?>

<section style="background-color: #eee; margin-top: 100px; width: 95%; margin: 0 auto; border-radius: 12px" class="shadow">
  <div class="container py-5">

    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow">
          <div class="card-body text-center">
            <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" alt="avatar" class="rounded-circle img-fluid shadow" style="width: 150px;">
            <h5 class="my-3"><?= $user["name"] ?></h5>
            <p class="text-muted mb-1"><?= $user["email"] ?></p>
            <p class="text-muted mb-4"><?= $user["address"] ?></p>
            <div class="d-flex justify-content-center mb-2">
              <button type="button" class="btn btn-outline-primary ms-1">Üzenet küldése</button>
            </div>
          </div>
        </div>


        <div class="card mb-4 shadow">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Név</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0"><?= $user["name"] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Foglalkozás</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0"><?= $user["profession"] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Telefonszám</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0"><?= $user["mobile"] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Lakcim</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $user["address"] ?></p>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="row">
          <div class="col-xs-12">
            <div class="card mb-4 mb-md-0 p-2 rounded rounded-lg">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Nyelvek</span>
                </p>
                <?php foreach ($user["langs"] as $language) : ?>
                  <div class="row d-flex align-items-center justify-content-center border mt-1 p-1">
                    <div class="col-sm-3"><?= Languages[$language["lang"]]["Hu"] ?></div>
                    <div class="col-sm-3"><?= Levels[$language["level"]]["Hu"] ?></div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
          <div class="col-xs-12 mt-4">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Érdkelődés</span>
                </p>
                <?php foreach ($user["tasks"] as $task) : ?>
     
                  <div class="row d-flex align-items-center justify-content-center border mt-1 p-1">
                    <div class="col-xs-12"><?= TASK_AREAS["areas"][$task["task"]]["Hu"] ?></div>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </div>
          <div class="col-xs-12 mt-4">
            <div class="card mb-1 mb-md-0">
              <div class="card-body">
                <p class="mb-1 "><span class="text-primary font-italic me-1">Megjelölt dátumok</span></p>
                <div class="card-body p-0">
                  <?php foreach ($user["dates"] as $date) : ?>
                    <i class="fas fa-globe fa-lg text-warning"></i>
                    <button class="mb-0 btn btn-primary"><?= $date["date"] ?></button>
                  <?php endforeach ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 mt-4">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <p><span class="text-primary font-italic me-1">Dokumentumok</span>
                </p>
                <?php foreach ($user["documents"] as $document) : ?>
                  <div class="row d-flex align-items-center justify-content-center border mt-1 p-1">
                    <div class="col-8">
                      <a href="/public/assets/uploads/documents/users/<?= $document["name"] ?>"> <?= $document["name"] ?></a>
                    </div>
                    <div class="col-4">
                      <span> <?= UPLOAD_DOCUMENTS["types"][$document["type"]]["Hu"] ?></span>
                    </div>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>