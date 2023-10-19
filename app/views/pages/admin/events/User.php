<?php

$user = $params["user"] ?? null;
$event = $params["event"] ?? null;
$tasks = $params["tasks"] ?? null;
?>

<div class="container">
  <div class="row">
    <div class="col-12 my-5">
      <a href="/admin/registrations">Vissza a regisztráltakhoz</a>
    </div>
    <div class="col-12 d-flex align-items-center justify-content-center">
      <section>
        <div class="container py-5">

          <div class="row">
            <div class="col-lg-4">
              <div class="card shadow">
                <div class="card-body text-center">
                  <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" alt="avatar" class="rounded-circle img-fluid shadow" style="width: 150px; height: 150px;">
                  <h5 class="my-3"><?= $user["name"] ?></h5>
                  <p class="text-muted mb-1"><?= $user["email"] ?></p>
                  <p class="text-muted mb-4"><?= $user["address"] ?></p>
                  <div class="d-flex justify-content-center mb-2">
                    <button type="button" class="btn btn-info text-light ms-1">Üzenet küldése</button>
                    <?= $user["isAccepted"] ?? false === true ?
                      '<button type="button" class="btn btn-danger ms-1">Visszavonás</button>'
                      :
                      '<a href="/subscription/accept/' . $user["id"] . '" type="button" class="btn btn-success ms-1">Jelentkezés elfogadása</a>'
                    ?>
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
              <div class="bg-dark p-2">
                <span class="text-light  me-1"><b>Nyelvek</b></span>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="card bg-light mb-4 mb-md-0 p-2 rounded rounded-lg">
                    <div class="card-body">
                      <?php foreach ($user["langs"] as $language) : ?>
                        <div class="row d-flex align-items-center justify-content-center mt-1 p-1">
                          <div class="col-sm-3"><?= Languages[$language["lang"]]["Hu"] ?></div>
                          <div class="col-sm-3"><?= Levels[$language["level"]]["Hu"] ?></div>
                        </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 mt-4">
                  <div class="bg-dark p-2">
                    <span class="text-light me-1"><b>Érdeklődés</b></span>
                  </div>
                  <div class="card mb-4 mb-md-0 bg-light">
                    <div class="card-body">
                      <h1>Fejlesztés alatt</h1>
                      <?php foreach ($user["tasks"] as $task) : ?>
                        <?php
                        $taskValues = array_column($tasks, "task");
                        $color = in_array($task["task"], $taskValues) ? 'green' : 'red  ';

                        ?>
                        <div class="row d-flex align-items-center justify-content-center mt-1 p-1 text-light" style="background-color: <?= $color ?>;">
                          <div class="col-xs-12"><b><?= TASK_AREAS["areas"][$task["task"]]["Hu"] ?></b></div>
                        </div>
                      <?php endforeach ?>


                    </div>
                  </div>
                </div>

                <div class="col-xs-12 mt-4">
                  <div class="bg-dark p-2">
                    <span class="text-light  me-1"><b>Dokumentumok</b></span>
                  </div>
                  <div class="card bg-light mb-4 mb-md-0">
                    <div class="card-body r-none ">
                      <?php foreach ($user["documents"] as $document) : ?>
                        <div class="row d-flex align-items-center justify-content-center mt-1 p-1">
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
    </div>
  </div>
</div>