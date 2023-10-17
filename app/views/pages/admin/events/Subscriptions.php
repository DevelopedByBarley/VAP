<?php
$subscriptions = $params["subscriptions"];

?>

<div class="container">
  <div class="row">
    <div class="d-flex align-items-center justify-content-center flex-column w-100">

      <h1 class="text-center my-5">Eseményre regisztrált felhasználók</h1>
      <hr class="w-100">

      <div class="table-responsive w-100" id="registrations-table">
        <table class="table">
          <thead class="bg-dark text-light">
            <tr>
              <th>Név</th>
              <th>Foglalkozás</th>
              <th>Telefonszám</th>
              <th>Profil</th>
              <th>Műveletek</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subscriptions as $index => $user) : ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="<?= isset($user["fileName"]) && $user["fileName"] !== '' ? '/public/assets/uploads/images/users/' . $user["fileName"] : '/public/assets/icons/bear.png' ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                    <div class="ms-3">
                      <p class="fw-bold mb-1"> <?= $user["name"] ?></p>
                      <p class="text-muted mb-0"> <?= $user["email"] ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="ms-3">
                    <?= $user["profession"] ?>
                  </div>
                </td>
                <td>
                  <p><?= $user["mobile"] ?></p>
                </td>
                <td>
                  <?= $user["userRefId"] ? '<i class="bi bi-check-circle-fill"></i>' : '<i class="bi bi-x-circle-fill"></i>' ?>
                </td>
                <td>
                  <a href="/admin/event/user/<?= $user["id"] ?>" class="btn btn-outline-primary">Megtekintés</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>