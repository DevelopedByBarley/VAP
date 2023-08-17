<form enctype="multipart/form-data" action="/admin/events/new" method="POST" class="form">

  <h1 class="display-5">Esemény hozzáadása</h1>
  <hr class="mb-5">

  <div class="form-outline mb-4">
    <label class="form-label" for="nameInHu">Név</label>
    <input type="text" id="name" class="form-control" name="nameInHu" required placeholder="Esemény neve magyarul" />
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="nameInEn">Név angolul</label>
    <input type="text" id="name" class="form-control" name="nameInEn" required placeholder="Esemény neve angolul" />
  </div>

  <div class="form-outline mb-4">
    <label class="form-label">Esemény dátuma</label>
    <br>
    <input type="date" name="date" class="mt-1" required />
  </div>

  <div class="form-outline mb-4">
    <label class="form-label" for="descriptionHu">Rövid leirás</label>
    <textarea class="form-control" id="descriptionHu" rows="4" name="descriptionInHu" required placeholder="Esemény rövid leirása"></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="descriptionEn">Rövid leirás angolul</label>
    <textarea class="form-control" id="descriptionEn" rows="4" name="descriptionInEn" required placeholder="Esemény rövid leirása angolul"></textarea>
  </div>

  <div class="form-outline border p-3">
    <div id="event-links-container">

    </div>
    <button class="btn btn-outline-primary mb-3" id="add-event-link-btn">Online felületek hozzáadása</button>
  </div>

  <div class="form-outline mb-4">
    <label for="formFile" class="form-label">Választható feladatok hozzáadása</label>
    <?php foreach (REGISTRATION_TASKS as $index => $task) : ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="<?= $index ?>" name="task[]">
        <label class="form-check-label">
          <?= $task["Hu"] ?>
        </label>
      </div>
    <?php endforeach ?>
  </div>

  <div class="form-outline border p-3">
    <div id="event-dates-container">

    </div>
    <button class="btn btn-outline-primary mb-3" id="add-event-date-btn">Választható dátum hozzáadása</button>
  </div>


  <div class="form-outline mb-4">
    <div class="mb-3 mt-3">
      <label for="formFile" class="form-label">Fénykép feltöltése</label>
      <input class="form-control" type="file" id="formFile" name="image" required>
    </div>
  </div>


  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>