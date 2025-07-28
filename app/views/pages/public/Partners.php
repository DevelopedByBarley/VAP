<?php
$partners = $params["partners"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
?>

<link rel="stylesheet" href="/public/css/content.css?v=<?php echo time() ?>" />

<div class="container-fluid py-5">
  <!-- Hero Section -->
  <section class="row mb-5">
    <div class="col-12 text-center mt-5">
      <div class="hero-content">
        <h1 class="hero-title mb-4">
          <span class="volunteers-title"><?= CONTENT["partners"]["other_partners"][$lang] ?? 'HIBA' ?></span>
        </h1>
        <!-- <div class="hero-divider mx-auto mb-4"></div> -->
        <p class="lead text-muted">
          <?= $lang === 'Hu' ? 'Megismerheted azokat a szervezeteket és intézményeket, akikkel együttműködünk' : 
              ($lang === 'En' ? 'Meet the organizations and institutions we collaborate with' : 
               'Conoce las organizaciones e instituciones con las que colaboramos') ?>
        </p>
      </div>
    </div>
  </section>

  <!-- Partners Grid -->
  <section class="row g-4">
    <?php foreach ($partners as $partner) : ?>
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <a href="<?= $partner["link"] ?? '#' ?>" 
           class="text-decoration-none h-100 d-block partner-card-link"
           target="<?= !empty($partner["link"]) ? '_blank' : '_self' ?>"
           rel="<?= !empty($partner["link"]) ? 'noopener noreferrer' : '' ?>">
          <div class="card h-100 modern-card partner-card border-0 shadow-sm">
            <!-- Partner Image -->
            <div class="card-img-container">
              <div class="partner-image-wrapper">
                <img src="/public/assets/uploads/images/partners/<?= $partner["fileName"] ?>" 
                     alt="<?= htmlspecialchars($partner["name"]) ?> logo"
                     class="partner-image"
                     loading="lazy">
              </div>
            </div>
            
            <!-- Card Body -->
            <div class="card-body d-flex flex-column">
              <!-- Partner Type Badge -->
              <div class="mb-3">
                <?php
                $sup = CONTENT["partners"]["sup_partners"]["short"][$lang] ?? 'Támogató';
                $coop = CONTENT["partners"]["coop_partners"]["short"][$lang] ?? 'Együttműködő';
                $badgeClass = $partner["type"] === "support" ? 'badge-support' : 'badge-cooperation';
                $badgeText = $partner["type"] === "support" ? $sup : $coop;
                ?>
                <span class="badge <?= $badgeClass ?> px-3 py-2">
                  <i class="bi bi-<?= $partner["type"] === "support" ? 'heart-fill' : 'handshake' ?> me-1"></i>
                  <?= $badgeText ?>
                </span>
              </div>
              
              <!-- Partner Name -->
              <h4 class="card-title mb-3 fw-bold"><?= htmlspecialchars($partner["name"]) ?></h4>
              
              <!-- Partner Description -->
              <p class="card-text flex-grow-1 text-muted">
                <?php 
                $description = $partner[languageSwitcher("description")] ?? '';
                // Decode HTML entities and clean up the text
                $description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
                // Replace line breaks with HTML breaks
                $description = nl2br($description);
                // Trim extra whitespace
                $description = trim($description);
                echo $description;
                ?>
              </p>
              
              <!-- Call to Action -->
              <?php if (!empty($partner["link"])) : ?>
                <div class="mt-auto">
                  <span class="btn primary-btn btn-sm w-100">
                    <i class="bi bi-arrow-up-right me-1"></i>
                    <?= $lang === 'Hu' ? 'Látogasd meg' : ($lang === 'En' ? 'Visit Website' : 'Visitar Sitio') ?>
                  </span>
                </div>
              <?php endif ?>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach ?>
  </section>
  
  <!-- Back to Home Button -->
  <section class="row mt-5">
    <div class="col-12 text-center">
      <a href="/" class="btn btn-pink btn-lg px-5 py-3">
        <i class="bi bi-house me-2"></i>
      <?= $lang === 'Hu' ? 'Vissza a főoldalra' : ($lang === 'En' ? 'Back to Home' : 'Volver al Inicio') ?>
      </a>
    </div>
  </section>
</div>