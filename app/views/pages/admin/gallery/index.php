<?php
  $galleryData = $params["galleryData"] ?? null;
  $galleryImages = $galleryData["gallery"] ?? [];
  $events = $params["events"] ?? [];
  $admin = $params["admin"] ?? null;
  
  $num_of_page = $galleryData["numOfPage"] ?? 1;
  $active_page = isset($_GET["offset"]) ? (int)$_GET["offset"] : 1;


  // Events tömb átalakítása ID alapján gyors kereséshez
  $eventsById = [];
  foreach ($events as $event) {
    $eventsById[$event['eventId']] = $event;
  }
?>

<link rel="stylesheet" href="/public/css/admin/gallery.css?v=<?= time() ?>">

<div class="container-fluid">
  <div class="row">
    <div class="d-flex align-items-center justify-content-center flex-column my-4">
      <h1>Galéria kezelése</h1>
      
      <!-- Pagináció tetején -->
      <?php if ($num_of_page > 1): ?>
      <nav class="mt-3">
        <ul class="pagination">
          <?php if ($active_page > 1) : ?>
            <li class="page-item"><a class="page-link" href="/admin/gallery?offset=<?= $active_page - 1 ?>">Előző</a></li>
          <?php endif ?>
          <?php for ($i = 1; $i <= $num_of_page; $i++) : ?>
            <li class="page-item <?= $active_page === $i ? "active" : "" ?>">
              <a class="page-link" href="/admin/gallery?offset=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor ?>
          <?php if ($active_page < $num_of_page) : ?>
            <li class="page-item"><a class="page-link" href="/admin/gallery?offset=<?= $active_page + 1 ?>">Következő</a></li>
          <?php endif ?>
        </ul>
      </nav>
      <?php endif; ?>

      <!-- Új kép hozzáadása gomb -->
      <div class="mb-3">
        <a href="/admin/gallery/create" class="btn btn-primary">
          <i class="bi bi-plus-circle"></i> Új kép hozzáadása
        </a>
      </div>
    </div>

    <div class="table-responsive w-100">
      <table class="table bg-white table-hover">
        <thead class="bg-dark text-light">
          <tr>
            <th>Kép</th>
            <th>Fájlnév</th>
            <th>Leírás</th>
            <th>Hozzárendelt esemény</th>
            <th>Feltöltve</th>
            <th>Műveletek</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($galleryImages)): ?>
            <tr>
              <td colspan="6" class="text-center py-4">
                <i class="bi bi-images" style="font-size: 3rem; color: #ccc;"></i>
                <p class="mt-2 text-muted">Még nincsenek képek a galériában</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($galleryImages as $image) : ?>
              <tr>
                <!-- Kép thumbnail -->
                <td>
                  <div class="gallery-thumbnail" 
                       style="width: 80px; height: 80px; background: url('/public/assets/images/gallery/<?= $image['fileName'] ?>') center center/cover no-repeat; border-radius: 8px; border: 2px solid #ddd;">
                  </div>
                </td>
                
                <!-- Fájlnév -->
                <td>
                  <p class="fw-normal mb-1"><?= $image['fileName'] ?></p>
                </td>
                
                <!-- Leírás -->
                <td>
                  <p class="fw-normal mb-1" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                    <?= htmlspecialchars($image['description'] ?? 'Nincs leírás') ?>
                  </p>
                </td>
                
                <!-- Hozzárendelt esemény -->
                <td>
                  <?php if ($image['event_id'] && isset($eventsById[$image['event_id']])): ?>
                    <span class="badge bg-primary p-2">
                      <?= htmlspecialchars($eventsById[$image['event_id']]['nameInHu']) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">
                      <i class="bi bi-dash-circle"></i> Nincs eseményhez rendelve
                    </span>
                  <?php endif; ?>
                </td>
                
                <!-- Feltöltve -->
                <td>
                  <?= isset($image['created_at']) ? date('Y-m-d H:i', strtotime($image['created_at'])) : 'Ismeretlen' ?>
                </td>
                
                <!-- Műveletek -->
                <td>
                  <a href="/public/assets/images/gallery/<?= $image['fileName'] ?>" class="btn btn-sm btn-outline-primary lightbox" title="Nagyítás">
                    <i class="bi bi-zoom-in"></i>
                  </a>
                  <a href="/admin/gallery/edit/<?= $image['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Szerkesztés">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $image['id'] ?>" title="Törlés">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>

              <!-- Törlés modal -->
              <div class="modal fade" id="deleteModal<?= $image['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Kép törlése</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <p>Biztosan törölni szeretnéd ezt a képet?</p>
                      <img src="/public/assets/images/gallery/<?= $image['fileName'] ?>" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                      <form method="POST" action="/admin/gallery/delete/<?= $image['id'] ?>" style="display: inline;">
                        <button type="submit" class="btn btn-danger">Törlés</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagináció alul -->
    <?php if ($num_of_page > 1): ?>
    <div class="d-flex justify-content-center my-4">
      <nav>
        <ul class="pagination">
          <?php if ($active_page > 1) : ?>
            <li class="page-item"><a class="page-link" href="/admin/gallery?offset=<?= $active_page - 1 ?>">Előző</a></li>
          <?php endif ?>
          <?php for ($i = 1; $i <= $num_of_page; $i++) : ?>
            <li class="page-item <?= $active_page === $i ? "active" : "" ?>">
              <a class="page-link" href="/admin/gallery?offset=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor ?>
          <?php if ($active_page < $num_of_page) : ?>
            <li class="page-item"><a class="page-link" href="/admin/gallery?offset=<?= $active_page + 1 ?>">Következő</a></li>
          <?php endif ?>
        </ul>
      </nav>
    </div>
    <?php endif; ?>
  </div>
</div>

<style>
  .gallery-thumbnail {
    cursor: pointer;
    transition: transform 0.2s ease;
  }
  
  .gallery-thumbnail:hover {
    transform: scale(1.05);
  }
  
  .table td {
    vertical-align: middle;
  }
</style>