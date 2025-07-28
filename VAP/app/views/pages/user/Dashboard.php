<link rel="stylesheet" href="/public/css/user/dashboard.css?v=<?php echo time() ?>">

<?php
$user = $params["user"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$events = $params["event"] ?? null;
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
  <div class="row mt-3">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-center">
        <div class="btn-group mb-5">
          <a href="/user/logout" class="btn btn-outline-danger m-1"><?= BUTTONS["logout"][$lang] ?? 'HIBA' ?></a>
          <a href="/user/settings" class="btn btn-outline-dark m-1"><?= DASHBOARD["about"]["profile_settings_btn"][$lang] ?? 'HIBA' ?></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="p-lg-4 text-black">
        <div class="mb-5">
          <p class="lead fw-normal mb-1 my-4"><?= DASHBOARD["about"]["title"][$lang] ?? 'HIBA' ?></p>
          <div class="p-xxl-4" style="background-color: #f8f9fa;">
            <div class="card mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0"><?= DASHBOARD["about"]["name"][$lang] ?? 'HIBA' ?></p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["name"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0"><?= DASHBOARD["about"]["email"][$lang] ?? 'HIBA' ?></p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["email"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0"><?= DASHBOARD["about"]["phone"][$lang] ?? 'HIBA' ?></p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["mobile"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0"><?= DASHBOARD["about"]["address"][$lang] ?? 'HIBA' ?></p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= $user["address"] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0"><?= DASHBOARD["about"]["createdAt"][$lang] ?? 'HIBA' ?></p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?= date("Y-m-d", $user["createdAt"]) ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-body d-flex align-items-center justify-content-center flex-column" style="overflow-y: scroll; min-height: 350px">
          <div id="subscriptions" class="p-2 d-flex align-items-center justify-content-center flex-column w-100">
            <h2 class="text-center"><?= PROFILE["subscriptions"]["title"][$lang] ?? 'Név' ?></h2>
            <?php if (!isset($subscriptions) || count($subscriptions) === 0) : ?>
              <h5 class="text-center mb-3"><?= PROFILE["subscriptions"]["no_subscriptions"][$lang] ?? 'Hiba' ?></h5>
              <!--EVENT ROW -->
              <?php if ($events) : ?>
                <div class="btn-group text-center">
                  <a href="/#latest-events" class="btn primary-btn"><?= DASHBOARD["subscriptions"]["next_event"][$lang] ?? 'Hiba' ?></a>
                </div>
              <?php else : ?>
                <h6><?= DASHBOARD["subscriptions"]["no_events"][$lang] ?></h6>
              <?php endif ?>
            <?php else : ?>
              <div class="row w-100">
                <?php foreach ($subscriptions as $subscription) : ?>

                  <div class="col-12 mt-3">
                    <div class="card">
                      <a class="link" href="/event/<?= $subscription['slug'] ?>">
                        <h5 class="card-header"><?= $subscription[languageSwitcher("name")] ?></h5>
                      </a>
                      <div class="card-body">
                        <p class="card-text"><?= $subscription[languageSwitcher("description")] ?></p>
                        <div class="btn-group">
                          <button type="button" class="btn btn-outline-dark m-2" data-bs-toggle="modal" data-bs-target="#subModal<?= $subscription["eventId"] ?>">
                            <?= DASHBOARD["subscriptions"]["modals"]["overview"][$lang] ?? 'HIBA' ?>
                          </button>
                          <button type="button" class="btn btn-outline-danger m-2" data-bs-toggle="modal" data-bs-target="#deleteSubModal<?= $subscription["eventId"] ?>">
                            <?= DASHBOARD["subscriptions"]["modals"]["delete_sub"][$lang] ?? 'HIBA' ?>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="modal fade" id="subModal<?= $subscription["eventId"] ?>" tabindex="-1" aria-labelledby="subModalLabel<?= $subscription["eventId"] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="subModalLabel<?= $subscription["eventId"] ?>">
                            <?= DASHBOARD["subscriptions"]["modals"]["overview"][$lang] ?? 'HIBA' ?>
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-12 text-center">
                              <img src="/public/assets/uploads/images/events/<?= $subscription['fileName']; ?>" class="border border-circle p-2" alt="" style="height: 100px; width: 100px">
                              <h1 class="mt-2"><?= $subscription[languageSwitcher("name")] ?></h1>
                              <h5><?= $subscription["date"] ?> - <?= $subscription["end_date"] ?></h5>
                            </div>
                          </div>
                          <hr>
                          <div>
                            <h4>
                              <?= DASHBOARD["subscriptions"]["modals"]["overview"][$lang] ?? 'HIBA' ?>:
                            </h4>
                            <p class="mt-3">
                              <b> <?= DASHBOARD["about"]["name"][$lang] ?? 'HIBA' ?>:</b> <?= $subscription["name"] ?>
                            </p>
                            <p class="mt-3">
                              <b><?= DASHBOARD["about"]["email"][$lang] ?? 'HIBA' ?></b> <?= $subscription["email"] ?>
                            </p>
                            <p class="mt-3">
                              <b><?= DASHBOARD["about"]["phone"][$lang] ?? 'HIBA' ?>:</b> <?= $subscription["mobile"] ?>
                            </p>
                            <p class="mt-3">
                              <b><?= DASHBOARD["about"]["address"][$lang] ?? 'HIBA' ?>:</b> <?= $subscription["address"] ?>
                            </p>
                            <hr>
                            <div class="mt-3">
                              <b class="mb-2 d-block"><?= DASHBOARD["subscriptions"]["modals"]["interest"][$lang] ?? 'HIBA' ?>:</b>
                              <?php foreach ($subscription["tasks"] as $value) : ?>
                                <p>
                                  - <?= TASK_AREAS["areas"][$value["task"]][$lang] ?? '' ?>
                                </p>
                              <?php endforeach ?>
                            </div>
                            <hr>
                            <div class="mt-3">
                              <b class="d-block mb-2"><?= DASHBOARD["subscriptions"]["modals"]["dates"][$lang] ?? 'HIBA' ?>:</b>
                              <?php foreach ($subscription["dates"] as $value) : ?>
                                <p>
                                  - <?= $value["date"] ?? '' ?>
                                </p>
                              <?php endforeach ?>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <?= DASHBOARD["subscriptions"]["modals"]["back"][$lang] ?? 'HIBA' ?>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>



                  <div class="modal fade" id="deleteSubModal<?= $subscription["eventId"] ?>" tabindex="-1" aria-labelledby="deleteSubModalLabel<?= $subscription["eventId"] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteSubModalLabel<?= $subscription["eventId"] ?>">
                            <?= DASHBOARD["subscriptions"]["modals"]["delete_sub"][$lang] ?? 'HIBA' ?>
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <?= DASHBOARD["subscriptions"]["modals"]["delete_perm"][$lang] ?? 'HIBA' ?>
                          <span class="border border-danger p-1 text-danger mt-1 d-inline-block"><?= $subscription[languageSwitcher("name")] ?></span>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <?= DASHBOARD["subscriptions"]["modals"]["back"][$lang] ?? 'HIBA' ?>
                          </button>
                          <a href="/event/registration/delete/<?= $subscription["eventId"] ?>" type="button" class="btn btn-primary">
                            <?= DASHBOARD["subscriptions"]["modals"]["delete_sub"][$lang] ?? 'HIBA' ?>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
              <div class="row mt-5">
                <div class="col-12">
                  <a href="/#latest-events" class="btn primary-btn"><?= DASHBOARD["subscriptions"]["next_event"][$lang] ?? 'Hiba' ?></a>

                </div>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>