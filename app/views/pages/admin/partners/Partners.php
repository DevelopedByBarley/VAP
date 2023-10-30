<link rel="stylesheet" href="/public/css/admin/partners.css?v=<?= time() ?>">



<?php
$partners = $params["partners"] ?? null;
$num_of_page = (int)$params["numOfPage"];
$active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;
?>

<div class="container my-5">
  <div class="row">
    <div id="admin-partners">
      <?php if (!isset($partners) || count($partners) === 0) : ?>
        <div id="no-partners" class="text-center">
          <h1 class="mb-3">Jelenleg nincs egy partner sem!</h1>
          <a href="/admin/partners/new" class="btn btn-lg btn-outline-dark">Partner hozzáadása</a>
        </div>
      <?php else : ?>
        <h1 class="text-center mb-2" style="margin-top: 70px;">Partnerek</h1>
        <hr class="w-100">
        <nav aria-label="Page navigation" class="mt-5 mb-5">
          <ul class="pagination d-flex align-items-center justify-content-center">
            <?php if ($active_page > 1) : ?>
              <li class="page-item"><a class="page-link" href="/admin/partners?offset=<?= $active_page - 1 ?>">Előző</a></li>
            <?php endif ?>
            <?php for ($i = 1; $i <= (int)$num_of_page; $i++) : ?>
              <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/partners?offset=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>
            <?php if ($active_page < $num_of_page) : ?>
              <li class="page-item"><a class="page-link" href="/admin/partners?offset=<?= $active_page + 1 ?>">Következő</a></li>
            <?php endif ?>
        </nav>
        </ul>
        <div class="table-responsive w-100 rounded" id="partners-table">
          <table class="table align-middle mb-0 bg-white">
            <thead class="bg-dark text-light">
              <tr>
                <th>Név</th>
                <th>Létrehozva</th>
                <th>Müveletek</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($partners as $partner) : ?>
                <?php $current_partner = $partner["name"]; ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" alt="" style="width: 60px; height: 60px" class="rounded-circle" />
                      <div class="ms-3">
                        <p class="fw-bold mb-1"> <?= $partner["name"] ?> </p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <?= date("Y/m/d", $partner["createdAt"]) ?>
                  </td>
                  <td>

                    <div>
                      <a href="/admin/partners/update/<?= $partner["id"] ?>" class="btn m-2 btn-dark rounded-pill badge-success text-light"><i class="bi bi-arrow-clockwise"></i></a>
                      <span class="btn m-2 btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#partnerModal<?= $partner["id"] ?>"><i class="bi bi-trash"></i></span>
                    </div>
                  </td>
                </tr>

                <div class="modal fade" id="partnerModal<?= $partner["id"] ?>" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="partnerModalLabel">Figyelem!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_partner   ?> </span>&nbsp; nevű önkéntest?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                        <a href="/admin/partners/delete/<?= $partner["id"] ?>" class="btn btn-primary">Törlés</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <nav aria-label="Page navigation" class="mt-5 mb-5">
          <ul class="pagination d-flex align-items-center justify-content-center">
            <?php if ($active_page > 1) : ?>
              <li class="page-item"><a class="page-link" href="/admin/partners?offset=<?= $active_page - 1 ?>">Előző</a></li>
            <?php endif ?>
            <?php for ($i = 1; $i <= (int)$num_of_page; $i++) : ?>
              <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/partners?offset=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>
            <?php if ($active_page < $num_of_page) : ?>
              <li class="page-item"><a class="page-link" href="/admin/partners?offset=<?= $active_page + 1 ?>">Következő</a></li>
            <?php endif ?>
        </nav>


        <div class="text-center mt-5">
          <a href="/admin/partners/new" class="btn btn-outline-dark">Partner hozzáadása</a>
        </div>
    </div>
  <?php endif ?>
  </div>


</div>
</div>

<!-- <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
   <div class="d-flex align-items-center">
     
   </div>
   
 </li>


 </div> -->