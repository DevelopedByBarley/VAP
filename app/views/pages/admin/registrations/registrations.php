<?php
$users = $params["users"] ?? null;
$num_of_page = (int)$params["numOfPage"];
$active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;
$searchValue = $_GET["search"] ?? '';
?>

<div id="admin-registrations" class="d-flex align-items-center justify-content-center flex-column">

  <h1 class="text-center display-4 mt-5 mb-2">Regisztrációk</h1>
  <hr class="w-100">

  <form class="w-100">
    <div class="input-group mt-4">
      <input type="search" class="form-control rounded" placeholder="Keresés.." aria-label="Search" aria-describedby="search-addon" name="search" value="<?= $searchValue ?>" />
      <button type="submit" class="btn btn-outline-primary">Keresés</button>
    </div>
  </form>
  <nav aria-label="Page navigation example" class="mt-5 mb-5">
    <ul class="pagination">
      <?php if ($active_page > 1) : ?>
        <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page - 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Előző</a></li>
      <?php endif ?>
      <?php for ($i = 1; $i <= (int)$num_of_page; $i++) : ?>
        <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/registrations?offset=<?= $i ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>"><?= $i ?></a></li>
      <?php endfor ?>
      <?php if ($active_page < $num_of_page) : ?>
        <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page + 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Következő</a></li>
      <?php endif ?>
  </nav>
  </ul>
  <div class="table-responsive w-100" id="registrations-table">
    <table class="table bg-white">
      <thead class="bg-light">
        <tr>
          <th>Név</th>
          <th>Feladat terület</th>
          <th>Foglalkozás</th>
          <th>Telefonszám</th>
          <th>Program érdeklődés</th>
          <th>Regisztrált</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user) : ?>
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <img src="/public/assets/icons/bear.png" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                <div class="ms-3">
                  <p class="fw-bold mb-1"> <?= $user["name"] ?></p>
                  <p class="text-muted mb-0"> <?= $user["email"] ?></p>
                </div>
              </div>
            </td>
            <td>
              <p class="fw-normal mb-1"><?= $user["tasks"] ?></p>
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
              <p><?= $user["programs"] ?></p>
            </td>
            <td>
              <?= date("y-d-m", $user["createdAt"]) ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <nav aria-label="Page navigation example" class="mt-5 mb-5">
    <ul class="pagination">
      <?php if ($active_page > 1) : ?>
        <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page - 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Előző</a></li>
      <?php endif ?>
      <?php for ($i = 1; $i <= (int)$num_of_page; $i++) : ?>
        <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/registrations?offset=<?= $i ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>"><?= $i ?></a></li>
      <?php endfor ?>
      <?php if ($active_page < $num_of_page) : ?>
        <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page + 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Következő</a></li>
      <?php endif ?>
  </nav>
</div>
</div>