<link rel="stylesheet" href="/public/css/admin/registrations.css?v=<?= time() ?>">


<?php
$users = $params["users"] ?? null;
$num_of_page = (int)$params["numOfPage"];
$active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;
$searchValue = $_GET["search"] ?? '';
?>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div id="admin-registrations" class="d-flex align-items-center justify-content-center flex-column">

        <h1 class="text-center mt-5 mb-2">Regisztrációk</h1>
        <hr class="w-100">

        <form class="w-100">
          <div class="input-group mt-4">
            <input type="search" class="form-control rounded" placeholder="Keresés.." aria-label="Search" aria-describedby="search-addon" name="search" value="<?= $searchValue ?>" />
            <button type="submit" class="btn btn-outline-primary">Keresés</button>
          </div>
        </form>
        <nav class="mt-5 mb-5">
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
          </ul>
        </nav>
        <div class="table-responsive w-100" id="registrations-table">
          <table class="table bg-white table-hover">
            <thead class="bg-dark text-light">
              <tr>
                <th>Név</th>
                <th>Feladat terület</th>
                <th>Foglalkozás</th>
                <th>Telefonszám</th>
                <th>Program érdeklődés</th>
                <th>Regisztrált</th>
                <th>Műveletek</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $index => $user) : ?>
                <?php $current_user = $user["name"] ?>
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
                  <td>
                    <div class="btn-group">
                      <a href="/admin/user/<?= $user["id"] ?>" class="btn btn-primary m-1">Megtekintés</a>
                      <div class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#userModal<?= $user["id"] ?>">Bannolás</div>

                    </div>
                  </td>
                </tr>



                <div class="modal fade" id="userModal<?= $user["id"] ?>" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Figyelem!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Biztosan <b class="text-danger">bannolod</b> a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_user   ?> </span>&nbsp; nevű felhasználót?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                        <a href="/admin/ban-user/<?= $user["id"] ?>" class="btn btn-primary">Törlés</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <nav class="mt-5 mb-5">
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
  </div>
</div>