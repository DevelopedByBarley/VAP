<link rel="stylesheet" href="/public/css/user/dashboard.css?v=<?php echo time() ?>">

<?php
$user = $params["user"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>

<div class="container py-5">
  <div class="row bg-dark">
    <div class="col-12 col-sm-4 col-lg-2 d-flex align-items-end ms-sm-5 justify-content-start" style="min-height: 35vh">
      <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 200px; z-index: 1; filter: grayscale(100%)">
    </div>
    <div class="col-12 col-sm-4 col-lg-2 d-flex align-items-start justify-content-end flex-column text-light">
      <h5><?= $user["name"] ?></h5>
      <p><?= $user["address"] ?></p>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="p-lg-4 text-black">
        <div class="mb-5">
          <p class="lead fw-normal mb-1 my-4">About</p>
          <div class="p-4" style="background-color: #f8f9fa;">
            <div class="card mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Full Name</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["name"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Email</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["email"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Phone</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["mobile"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Address</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["address"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Profil létrehozva</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= date("Y-m-d", $user["createdAt"]) ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <div class="btn-group">
            <a href="/user/logout" class="btn btn-outline-danger m-1">Kijelentkezés</a>
            <a href="/user/settings" class="btn btn-outline-primary m-1">Profil szerkesztése</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-body d-flex align-items-center justify-content-center flex-column" style="overflow-y: scroll; min-height: 350px">
          <div id="subscriptions" class="p-2 d-flex align-items-center justify-content-center flex-column">
            <h2 class="text-center mb-5"><?= PROFILE["subscriptions"]["title"][$lang] ?? 'Név' ?></h2>

            <?php if (!isset($subscriptions) || count($subscriptions) === 0) : ?>
              <h5 class="text-center"><?= PROFILE["subscriptions"]["no_subscriptions"][$lang] ?? 'Név' ?></h5>
              <div class="text-center">
                <a href="/events" class="m-1 btn btn-success" id="event-btn">
                  <?= PROFILE["subscriptions"]["check_subscription_btn"][$lang] ?? 'Név' ?>
                </a>
              </div>
            <?php else : ?>
              <div class="row d-flex align-items-center justify-content-center">
                <?php foreach ($subscriptions as $subscription) : ?>

                  <div class="col-12 mt-3">
                    <div class="card">
                      <h5 class="card-header"><?= $subscription[languageSwitcher("name")] ?></h5>
                      <div class="card-body">
                        <p class="card-text"><?= $subscription[languageSwitcher("description")] ?></p>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#subModal<?= $subscription["eventId"] ?>">
                          Jelentkezés törlése
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- Modális ablak egyedi ID-vel -->
                  <div class="modal fade" id="subModal<?= $subscription["eventId"] ?>" tabindex="-1" aria-labelledby="subModalLabel<?= $subscription["eventId"] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="subModalLabel<?= $subscription["eventId"] ?>">Regisztráció törlése</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Biztosan törlöd az <span class="border border-danger p-1 text-danger mt-1 d-inline-block"><?= $subscription[languageSwitcher("name")] ?></span> nevű regisztrációdat?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                          <a href="/event/registration/delete/<?= $subscription["eventId"] ?>" type="button" class="btn btn-primary">Regisztráció törlése</a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>