<?php
$events = $params["events"] ?? [];
$admin = $params["admin"] ?? null;
?>

<link rel="stylesheet" href="/public/css/admin/gallery.css?v=<?= time() ?>">

<div class="container">
  <div class="row">
    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/gallery" method="POST" id="galleryForm">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1>Új kép hozzáadása a galériához</h1>
          <a href="/admin/gallery" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Vissza a galériához
          </a>
        </div>

        <hr class="mb-5">

        <!-- Kép feltöltés -->
        <div class="form-outline mb-4">
          <label class="form-label" for="fileName"><b>Kép fájl *</b></label>
          <input type="file" id="fileName" class="form-control" name="fileName" accept="image/*" required />
          <div class="form-text">Támogatott formátumok: JPG, JPEG, PNG, GIF, WEBP (Max: 10MB)</div>
        </div>



        <!-- Kép előnézet -->
        <div class="mb-4" id="imagePreview" style="display: none;">
          <label class="form-label"><b>Előnézet</b></label>
          <div class="border rounded p-3 text-center">
            <img id="previewImg" src="" alt="Kép előnézet" style="max-width: 300px; max-height: 300px; object-fit: contain;">
          </div>
        </div>

        <!-- Leírás -->
        <div class="form-outline mb-4">
          <label class="form-label" for="description"><b>Leírás</b></label>
          <textarea class="form-control" id="description" rows="3" name="description" placeholder="Opcionális leírás a képhez..."></textarea>
        </div>

        <!-- Esemény kiválasztása -->
        <div class="form-outline mb-4">
          <label class="form-label" for="event_id"><b>Eseményhez rendelés (opcionális)</b></label>
          <select class="form-select" id="event_id" name="event_id">
            <option value="">-- Válassz eseményt (opcionális) --</option>
            <?php foreach ($events as $event): ?>
              <option value="<?= $event['eventId'] ?>"><?= htmlspecialchars($event['nameInHu']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="form-text">Ha kiválasztasz egy eseményt, a kép hozzá lesz rendelve.</div>
        </div>

        <!-- Alt szöveg -->
        <div class="form-outline mb-4">
          <label class="form-label" for="altText"><b>Alt szöveg (akadálymentesítés)</b></label>
          <input type="text" id="altText" class="form-control" name="altText" placeholder="Rövid leírás a képről látássérülteknek" />
        </div>



        <!-- Publikálási beállítások -->
        <div class="form-outline mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" checked>
            <label class="form-check-label" for="is_public">
              <b>Publikus megjelenítés</b>
            </label>
            <div class="form-text">Ha be van jelölve, a kép megjelenik a nyilvános galériában.</div>
          </div>
        </div>

        <!-- Gombok -->
        <div class="d-flex gap-3 mt-5">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-cloud-upload"></i> Kép feltöltése
          </button>
          <button type="reset" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-clockwise"></i> Mezők törlése
          </button>
          <a href="/admin/gallery" class="btn btn-outline-danger">
            <i class="bi bi-x-circle"></i> Mégse
          </a>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
  // Kép előnézet
  document.getElementById('fileName').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (file) {
      // Fájl méret ellenőrzése (10MB)
      if (file.size > 10 * 1024 * 1024) {
        alert('A fájl túl nagy! Maximum 10MB méret engedélyezett.');
        e.target.value = '';
        preview.style.display = 'none';
        return;
      }

      // Fájl típus ellenőrzése
      if (!file.type.startsWith('image/')) {
        alert('Csak képfájlok tölthetők fel!');
        e.target.value = '';
        preview.style.display = 'none';
        return;
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      preview.style.display = 'none';
    }
  });

  // Form validáció
  document.getElementById('galleryForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('fileName');

    if (!fileInput.files.length) {
      e.preventDefault();
      alert('Kérlek válassz ki egy képfájlt!');
      fileInput.focus();
      return false;
    }
  });

  // Reset gomb kezelése
  document.querySelector('button[type="reset"]').addEventListener('click', function() {
    document.getElementById('imagePreview').style.display = 'none';
  });
</script>