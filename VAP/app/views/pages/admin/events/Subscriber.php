<?php

$sub = $params["user"];
$tasks = array_column($params["tasks"], "task");

?>

<div class="container">
  <div class="row">
    <div class="col-12 d-flex align-items-center justify-content-center">
      <section>
        <div class="container py-5">

          <div class="row">
            <div class="col-lg-4">
              <div class="card shadow">
                <div class="card-body text-center">
                  <img src="<?= isset($sub["fileName"]) && $sub["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $sub["fileName"] : '/public/assets/icons/bear.png' ?>" alt="avatar" class="rounded-circle img-fluid shadow" style="width: 150px; height: 150px;">
                  <p class="my-3">
                    <b style="font-size: 1.5rem"><?= $sub["name"] ?></b> (<span><?= $sub["lang"] ?></span>)
                  </p>
                  <p class="text-muted mb-1"><?= $sub["email"] ?></p>
                  <p class="text-muted mb-4"><?= $sub["address"] ?></p>
                  <div class="d-flex justify-content-center mb-2">
                    <a href="/admin/event/subscriber/email/<?= $sub["id"] ?>" type="button" class="btn btn-outline-primary ms-1">Üzenet küldése</a>
                    <?php if ((int)$sub["isAccepted"] === 0) : ?>
                      <a href="/admin/subscription/accept/<?= $sub["id"] ?>" class="btn btn-outline-success ms-1">Jelentkezés elfogadása</a>
                    <?php else : ?>
                      <a href="/admin/subscription/delete/<?= $sub["id"] ?>" class="btn btn-outline-success ms-1">Visszavonás</a>
                    <?php endif ?>
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
                      <p class="text-muted mb-0"><?= $sub["name"] ?></p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <p class="mb-0">Foglalkozás</p>
                    </div>
                    <div class="col-sm-8">
                      <p class="text-muted mb-0"><?= $sub["profession"] ?></p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <p class="mb-0">Telefonszám</p>
                    </div>
                    <div class="col-sm-8">
                      <p class="text-muted mb-0"><?= $sub["mobile"] ?></p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Lakcim</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0"><?= $sub["address"] ?></p>
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
                      <?php foreach ($sub["langs"] as $language) : ?>
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
                      <?php foreach ($tasks as $task) : ?>
                        <div class="row d-flex align-items-center justify-content-center border mt-1 p-1">
                          <div class="col-xs-12"><?= TASK_AREAS["areas"][$task]["Hu"] ?></div>
                        </div>
                      <?php endforeach ?>

                    </div>
                  </div>
                </div>

                <div class="col-xs-12 mt-4">
                  <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                      <p><span class="text-primary font-italic me-1">Dokumentumok</span>
                      </p>
                      <?php foreach ($sub["documents"] as $document) : ?>
                        <div class="row d-flex align-items-center justify-content-center border mt-1 p-1">
                          <div class="col-8">
                            <a href="/public/assets/uploads/documents/users/<?= $document["name"] ?>"> <?= $document["name"] ?></a>
                          </div>
                          <div class="col-4">
                            <span> <?= DOCUMENTS["types"][$document["type"]]["Hu"] ?></span>
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
    </div>
  </div>
</div>