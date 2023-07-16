<?php
$users = $params["users"] ?? null;
$num_of_page = (int)$params["numOfPage"];
$active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;

?>

<div id="admin-users" class="d-flex align-items-center justify-content-center flex-column">
  <?php if (!isset($users) || count($users) === 0) : ?>
  <?php else : ?>
    <h1 class="text-center display-4 mb-2">Regisztrációk listája</h1>
    <nav aria-label="Page navigation example" class="mt-5 mb-5">
      <ul class="pagination">
        <?php if ($active_page > 1) : ?>
          <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page - 1 ?>">Előző</a></li>
        <?php endif ?>
        <?php for ($i = 1; $i <= (int)$num_of_page; $i++) : ?>
          <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/registrations?offset=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor ?>
        <?php if ($active_page < $num_of_page) : ?>
          <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page + 1 ?>">Következő</a></li>
        <?php endif ?>
    </nav>
    </ul>
    <div class="table-responsive w-100">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Név</th>
            <th scope="col">Regisztrált</th>
            <th scope="col">Foglalkozás</th>
            <th scope="col">Telefonszám</th>
            <th scope="col">Program érdeklődés</th>
            <th scope="col">Feladat terület</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $index => $user) : ?>
            <tr>
              <td><?= $index + 1 ?>.</td>
              <td>
                <?= $user["name"] ?>
              </td>
              <td>
                <?= date("y-d-m", $user["createdAt"]) ?>
              </td>
              <td>
                <?= $user["profession"] ?>
              </td>
              <td>
                <?= $user["mobile"] ?>
              </td>
              <td>
                <?= $user["programs"] ?>
              </td>
              <td>
                <?= $user["tasks"] ?>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <nav aria-label="Page navigation example" class="mt-5 mb-5">
      <ul class="pagination">
        <?php if ($active_page > 1) : ?>
          <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page - 1 ?>">Előző</a></li>
        <?php endif ?>
        <?php for ($i = 1; $i <= (int)$num_of_page; $i++) : ?>
          <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/registrations?offset=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor ?>
        <?php if ($active_page < $num_of_page) : ?>
          <li class="page-item"><a class="page-link" href="/admin/registrations?offset=<?= $active_page + 1 ?>">Következő</a></li>
        <?php endif ?>
    </nav>
</div>
<?php endif ?>
</div>