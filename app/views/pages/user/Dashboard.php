<link rel="stylesheet" href="/public/css/user/dashboard.css?v=<?php echo time() ?>">

<?php
$user = $params["user"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>






<div id="dashboard" class="w-100">
  <div id="dashboard-header" class="w-100 d-flex align-items-center justify-content-center flex-column text-light shadow">
    <div class="text-center mb-2 mt-5">
      <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" style="height: 150px; width: 150px; border-radius: 100%;" class="shadow" />
    </div>

    <h1 class="text-center"><?= $user["name"] ?></h1>
    <b>
      <p class="text-center"><?= $user["email"] ?></p>
    </b>
    <p class="text-center"><?= PROFILE["header"]["createdAt"][$lang] ?? '' ?>: <?= date("y-d-m h:i", $user["createdAt"]) ?></p>
    <div class="text-center">
      <a href="/user/logout" class="m-1 btn btn-danger text-light" id="user-logout-button">
        <?= PROFILE["header"]["logoutBtn"][$lang] ?? 'Név' ?>
      </a>
      <a href="/user/settings" class="m-1 btn btn-secondary text-light" id="user-logout-button">
        <?= 'Profil szerkesztése' ?? 'Profil' ?>
      </a>
    </div>
  </div>

  <div id="subscriptions" class="border p-4 sc-color d-flex align-items-center justify-content-center flex-column">
    <h2 class="text-center mt-3 mb-5 text-light"><?= PROFILE["subscriptions"]["title"][$lang] ?? 'Név' ?></h2>

    <?php if (!isset($subscriptions) || count($subscriptions) === 0) : ?>
      <h5 class="text-center text-light"><?= PROFILE["subscriptions"]["no_subscriptions"][$lang] ?? 'Név' ?></h5>
      <div class="text-center">
        <a href="/events" class="m-1 btn text-light" id="event-btn">
          <?= PROFILE["subscriptions"]["check_subscription_btn"][$lang] ?? 'Név' ?>
        </a>
      </div>
    <?php else : ?>
      <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
          <?php foreach ($subscriptions as $subscription) : ?>
            <div class="col-12 col-lg-4 d-flex align-items-center justify-content-center">
              <div class="card r-border shadow" style="width: 21rem; min-height: 220px">
                <div class="card-body">
                  <h4><?= $subscription[languageSwitcher("name")] ?></h4>
                  <p class="card-text"><i style="font-size: 1.5rem;" class="bi bi-calendar-check"></i> <b><?= $subscription["date"] ?> </b></p>
                  <hr>
                  <div class="text-center">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#subModal<?= $subscription["eventId"] ?>">
                      Jelentkezés törlése
                    </button>
                  </div>
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
      </div>
    <?php endif ?>
  </div>


  