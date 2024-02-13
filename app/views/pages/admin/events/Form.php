<div class="container">
  <div class="row">

    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/events/new" method="POST">

        <h1>Esemény hozzáadása</h1>
        <hr class="mb-5">

        <div class="form-outline mb-4">
          <label class="form-label" for="nameInHu"><b>Név</b></label>
          <input type="text" id="name" class="form-control" name="nameInHu" required placeholder="Esemény neve magyarul" />
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="nameInEn"><b>Név angolul</b></label>
          <input type="text" id="name" class="form-control" name="nameInEn" required placeholder="Esemény neve angolul" />
        </div>

        <div class="form-outline mb-4">
          <label class="form-label"><b>Esemény Kezdő dátuma</b></label>
          <br>
          <input type="date" name="date" id="start-date" class="mt-1" min="<?= date('Y-m-d') ?>" required />
        </div>
        <div class="form-outline mb-4">
          <label class="form-label"><b>Esemény záró dátuma</b></label>
          <br>
          <input type="date" name="end_date" id="end-date" class="mt-1" min="<?= date('Y-m-d') ?>" required />
        </div>
        <div class="form-outline mb-4">
          <label class="form-label"><b>Regisztráció lezárásának dátuma</b></label>
          <br>
          <input type="date" name="reg_end_date" id="reg-end-date" class="mt-1" min="<?= date('Y-m-d') ?>" required />
        </div>

        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionHu"><b>Rövid leirás</b></label>
          <textarea class="form-control" id="descriptionHu" rows="4" name="descriptionInHu" required placeholder="Esemény rövid leirása"></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionEn"><b>Rövid leirás angolul</b></label>
          <textarea class="form-control" id="descriptionEn" rows="4" name="descriptionInEn" required placeholder="Esemény rövid leirása angolul"></textarea>
        </div>

        <div class="form-outline border p-3">
          <label for="formFile" class="form-label mt-3"><b>Kapcsolódó linkek hozzáadása</b></label>
          <div id="event-links-container">

          </div>
          <button class="btn btn-outline-primary mb-3" id="add-event-link-btn">Online felületek hozzáadása</button>
        </div>

        <div class="form-outline mb-4">
          <label for="formFile" class="form-label mt-3"><b>Választható feladatok hozzáadása</b></label>
          <?php foreach (TASK_AREAS["areas"] as $index => $task) : ?>
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
        <div class="form-outline border p-3">
          <label class="form-check-label">
            <span><b>Időzítő beállítása</b> <i> (Az esemény csak a beállított időpont után lesz publikus!)</i></span>
          </label>
          <div class="mt-3">
            <input type="datetime-local" id="meeting-time" name="timer" />
          </div>
        </div>





        <div class="form-outline mb-4">
          <div class="mb-3 mt-3">
            <label for="formFile" class="form-label"><b>Fénykép feltöltése</b> <i>(jpg, png)</i></label>
            <input class="form-control" type="file" id="formFile" name="image" required>
          </div>
        </div>


        <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
      </form>
    </div>
  </div>
</div>

<script src="/public/js/Event.Links.js"></script>
<script src="/public/js/Event.Dates.js"></script>