<link rel="stylesheet" href="/public/css/admin/events.css?v=<?= time() ?>">


<?php
$events = $params["events"] ?? null;

$num_of_page = $params["numOfPage"];

$active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;
?>


<div class="container">
  <div class="row vh-100">
    <div class="d-flex align-items-center justify-content-center flex-column my-5">
      <h1>Események</h1>
      <nav class="mt-3">
        <ul class="pagination">
          <?php if ($active_page > 1) : ?>
            <li class="page-item"><a class="page-link" href="/admin/events?offset=<?= $active_page - 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Előző</a></li>
          <?php endif ?>
          <?php for ($i = 1; $i <= $num_of_page; $i++) : ?>
            <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/events?offset=<?= $i ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>"><?= $i ?></a></li>
          <?php endfor ?>
          <?php if ($active_page < $num_of_page) : ?>
            <li class="page-item"><a class="page-link" href="/admin/events?offset=<?= $active_page + 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Következő</a></li>
          <?php endif ?>
        </ul>
      </nav>
    </div>

    <div class="table-responsive w-100" id="registrations-table">
      <table class="table bg-white table-hover">
        <thead class="bg-dark text-light">
          <tr>
            <th>Név</th>
            <th>Regisztráltak száma</th>
            <th>Start dátum</th>
            <th>Vége dátum</th>
            <th>Létrehozva</th>
            <th>Publikus</th>
            <th>Státusz</th>
            <th>Műveletek</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $index => $event) : ?>
            <?php $current_event = $event["nameInHu"] ?>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="<?= isset($event["fileName"]) && $event["fileName"] !== '' ? '/public/assets/uploads/images/events/' . $event["fileName"] : '/public/assets/icons/bear.png' ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                  <div class="ms-3">
                    <p class="fw-bold mb-1"> <?= $event["nameInHu"] ?></p>
                  </div>
                </div>
              </td>
              <td>
                <p class="fw-normal mb-1"><?= $event["subscriptions"] ?></p>
              </td>
              <td>
                <?= $event["date"] ?>
              </td>
              <td>
                <?= $event["end_date"] ?>
              </td>
              <td>
                <?= date('Y-m-d', $event["createdAt"]) ?>
              </td>
              <td>
                <?= (int)$event["isPublic"] === 1 ? '<i class="bi bi-check-circle-fill text-success" style="font-size: 1.2rem"></i>' : '<i class="bi bi-lg bi-x-circle-fill text-danger" style="font-size: 1.2rem"></i>' ?>
              </td>
              <td>
                <?= $event["reg_end_date"] <= date("Y-m-d") || $event["date"] <= date("Y-m-d") ? '<span class="badge bg-secondary p-2"><b>LEJÁRT</b></span>' : '<span class="badge bg-primary p-2"><b>AKTÍV</b></span>' ?>
              </td>

              <td>
                <a href="/admin/event/<?= $event["eventId"] ?>" class="btn btn-dark rounded-pill"><i class="bi bi-eye"></i></a>
                <a href="/admin/events/update/<?= $event["eventId"] ?>" class="btn btn-secondary rounded-pill text-light"><i class="bi bi-arrow-clockwise"></i></a>
                <span class="btn btn-danger rounded-pill badge-success" data-bs-toggle="modal" data-bs-target="#partnerModal<?= $event["eventId"] ?>"><i class="bi bi-trash"></i></span>
              </td>

            </tr>



            <div class="modal fade" id="partnerModal<?= $event["eventId"] ?>" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="partnerModalLabel">Figyelem!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Biztosan törlöd a &nbsp;<span class="text-danger border border-danger p-1"> <?= $current_event ?> </span>&nbsp; nevű eseményt?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                    <a href="/admin/events/delete/<?= $event["eventId"] ?>" class="btn btn-primary">Törlés</a>
                  </div>
                </div>
              </div>
            </div>


          <?php endforeach ?>
        </tbody>
      </table>
    </div>


    <div class="d-flex align-items-center justify-content-center">
      <nav class="mb-5">
        <ul class="pagination">
          <?php if ($active_page > 1) : ?>
            <li class="page-item"><a class="page-link" href="/admin/events?offset=<?= $active_page - 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Előző</a></li>
          <?php endif ?>
          <?php for ($i = 1; $i <= $num_of_page; $i++) : ?>
            <li class="page-item <?= $active_page === $i ?  "active" : "" ?>"><a class="page-link" href="/admin/events?offset=<?= $i ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>"><?= $i ?></a></li>
          <?php endfor ?>
          <?php if ($active_page < $num_of_page) : ?>
            <li class="page-item"><a class="page-link" href="/admin/events?offset=<?= $active_page + 1 ?><?= isset($_GET["search"]) && $_GET["search"] !== '' ? '&search=' . $_GET["search"] : '' ?>">Következő</a></li>
          <?php endif ?>
        </ul>
      </nav>
    </div>

    <div class="text-center my-5">
      <a href="/admin/events/new" class="btn btn-outline-dark d-inline-block">Esemény hozzáadása</a>
    </div>

  </div>

</div>