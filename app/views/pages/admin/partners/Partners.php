<?php
$partners = $params["partners"] ?? null;
$num_of_page = (int)$params["numOfPage"];
$active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;

?>

<div id="admin-partners" class="d-flex align-items-center justify-content-center flex-column">
  <?php if (!isset($partners) || count($partners) === 0) : ?>
    <div id="no-partners" class="text-center">
      <h1 class="display-3 mb-3">Jelenleg nincs egy partner sem!</h1>
      <a href="/admin/partners/new" class="btn btn-lg btn-outline-primary">Partner hozzáadása</a>
    </div>
  <?php else : ?>
    <h1 class="text-center display-4 mb-2">Partnerek listája</h1>
    <nav aria-label="Page navigation example" class="mt-5 mb-5">
      <ul class="pagination">
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
    <div class="table-responsive w-100">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Név</th>
            <th scope="col">Létrehozva</th>
            <th scope="col">Müveletek</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($partners as $partner) : ?>
            <?php $current_partner = $partner["name"]; ?>

            <tr>
              <th scope="row"><img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" alt="" style="width: 60px; height: 60px" class="rounded-circle" /></th>
              <td><?= $partner["name"] ?></td>
              <td>
                <?= $partner["createdAt"] ?>
              </td>
              <td>

                <div>
                  <a href="/admin/partners/update/<?= $partner["id"] ?>" class="btn m-2 btn-warning rounded-pill badge-success text-light"><i class="bi bi-arrow-clockwise"></i></a>
                  <span class="btn m-2 btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#exampleModal2<?= $partner["id"] ?>"><i class="bi bi-trash"></i></span>
                </div>
              </td>
            </tr>

            <div class="modal fade" id="exampleModal2<?= $partner["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Figyelem!</h5>
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
    <nav aria-label="Page navigation example" class="mt-5 mb-5">
      <ul class="pagination">
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
      <a href="/admin/partners/new" class="btn btn-outline-primary">Partner hozzáadása</a>
    </div>
</div>
<?php endif ?>
</div>



<!-- <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
   <div class="d-flex align-items-center">
     
   </div>
   
 </li>


 </div> -->