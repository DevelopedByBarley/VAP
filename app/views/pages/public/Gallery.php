<?php
$images = $params["images"] ?? [];
$events = $params["events"] ?? [];

// Events tömb átalakítása ID alapján gyors kereséshez
$eventsById = [];
foreach ($events as $event) {
  $eventsById[$event['eventId']] = $event;
}

// Képek csoportosítása események szerint
$groupedImages = [
  'with_event' => [],
  'without_event' => []
];

foreach ($images as $image) {
  if ($image['is_public'] == 0) {
    continue; // Csak a publikus képeket jelenítjük meg
  }

  if ($image['event_id'] && isset($eventsById[$image['event_id']])) {
    $eventId = $image['event_id'];
    if (!isset($groupedImages['with_event'][$eventId])) {
      $groupedImages['with_event'][$eventId] = [
        'event' => $eventsById[$eventId],
        'images' => []
      ];
    }
    $groupedImages['with_event'][$eventId]['images'][] = $image;
  } else {
    $groupedImages['without_event'][] = $image;
  }
}
?>

<link rel="stylesheet" href="/public/css/gallery.css?v=<?= time() ?>">

<div class="container-fluid py-5">
  <div class="row">
    <div class="col-12 text-center mb-5">
      <h1 class="display-4 fw-bold text-dark">Galéria</h1>
      <p class="lead text-muted">Programjaink és eseményeink pillanatai</p>
    </div>
  </div>

  <?php if (empty($images)): ?>
    <!-- Üres galéria állapot -->
    <div class="row">
      <div class="col-12 text-center py-5">
        <i class="bi bi-images display-1 text-muted mb-3"></i>
        <h3 class="text-muted">A galéria még üres</h3>
        <p class="text-muted">Hamarosan feltöltjük a legszebb pillanatokat!</p>
      </div>
    </div>
  <?php else: ?>

    <?php if (!empty($groupedImages['with_event'])): ?>
      <!-- Eseményekhez rendelt képek -->
      <?php foreach ($groupedImages['with_event'] as $eventGroup): ?>
        <div class="row mb-5" id="event-<?= $eventGroup['event']['eventId'] ?>">
          <div class="col-12">
            <div class="event-section">
              <!-- Esemény címe -->
              <div class="d-flex align-items-center mb-4">
                <div class="event-icon me-3">
                  <i class="bi bi-calendar-event"></i>
                </div>
                <div>
                  <h2 class="h3 mb-1"><?= htmlspecialchars($eventGroup['event']['nameInHu']) ?></h2>
                  <p class="text-muted mb-0">
                    <i class="bi bi-calendar3 me-1"></i>
                    <?= date('Y. m. d.', strtotime($eventGroup['event']['date'])) ?>
                    <?php if ($eventGroup['event']['end_date'] && $eventGroup['event']['end_date'] !== $eventGroup['event']['date']): ?>
                      - <?= date('Y. m. d.', strtotime($eventGroup['event']['end_date'])) ?>
                    <?php endif; ?>
                  </p>
                </div>
              </div>

              <!-- Esemény képei -->
              <div class="gallery row g-3" data-event="<?= $eventGroup['event']['eventId'] ?>">
                <?php foreach ($eventGroup['images'] as $image): ?>
                  <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-item">
                      <a href="/public/assets/images/gallery/<?= $image['fileName'] ?>"
                        class="gallery-link"
                        title="<?= htmlspecialchars($image['description'] ?? $eventGroup['event']['nameInHu']) ?>">
                        <div class="gallery-image">
                          <img src="/public/assets/images/gallery/<?= $image['fileName'] ?>"
                            alt="<?= htmlspecialchars($image['alt_text'] ?? $image['description'] ?? 'Galéria kép') ?>"
                            class="img-fluid">
                          <div class="gallery-overlay">
                            <i class="bi bi-zoom-in"></i>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($groupedImages['without_event'])): ?>
      <!-- Általános képek (eseményhez nem rendelt) -->
      <div class="row mb-5">
        <div class="col-12">
          <div class="general-section">
            <!-- Általános galéria címe -->
            <div class="d-flex align-items-center mb-4">
              <div class="event-icon me-3">
                <i class="bi bi-images"></i>
              </div>
              <div>
                <h2 class="h3 mb-1">Általános galéria</h2>
                <p class="text-muted mb-0">Egyéb pillanatok és képek</p>
              </div>
            </div>

            <!-- Általános képek -->
            <div class="gallery row g-3" data-event="general">
              <?php foreach ($groupedImages['without_event'] as $image): ?>
                <div class="col-6 col-md-4 col-lg-3">
                  <div class="gallery-item">
                    <a href="/public/assets/images/gallery/<?= $image['fileName'] ?>"
                      class="gallery-link"
                      title="<?= htmlspecialchars($image['description'] ?? 'Galéria kép') ?>">
                      <div class="gallery-image">
                        <img src="/public/assets/images/gallery/<?= $image['fileName'] ?>"
                          alt="<?= htmlspecialchars($image['alt_text'] ?? $image['description'] ?? 'Galéria kép') ?>"
                          class="img-fluid">
                        <div class="gallery-overlay">
                          <i class="bi bi-zoom-in"></i>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php endif; ?>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing gallery lightbox...');

    // Összegyűjtjük az összes galéria linket egy lightboxba
    const allGalleryLinks = document.querySelectorAll('.gallery-link');
    console.log('Found gallery links:', allGalleryLinks.length);

    if (allGalleryLinks.length > 0) {
      // Egyetlen lightbox az összes képhez - így működik a teljes lapozás
      const lightbox = new SimpleLightbox('.gallery-link', {
        overlay: true,
        spinner: true,
        nav: true, // Lapozó nyilak
        navText: ['❮', '❯'], // Egyszerű nyilak
        close: true,
        closeText: '✕',
        showCounter: true, // Képszámláló
        animationSlide: true,
        animationSpeed: 250,
        preloading: true,
        enableKeyboard: true, // Billentyűzet navigáció
        loop: true, // Végtelen hurok
        docClose: true, // Kattintás a háttérre = bezárás
        swipeTolerance: 50,
        className: 'gallery-lightbox'
      });

      console.log('Lightbox initialized successfully');
    }
    
    // Anchor link kezelése (eseményhez görgetés)
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            setTimeout(function() {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Kiemelő animáció
                targetElement.style.transform = 'scale(1.02)';
                targetElement.style.transition = 'transform 0.3s ease';
                setTimeout(function() {
                    targetElement.style.transform = 'scale(1)';
                }, 500);
            }, 100);
        }
    }
  });
</script>