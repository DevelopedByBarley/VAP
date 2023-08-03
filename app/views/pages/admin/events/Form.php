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
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="task[]">
      <label class="form-check-label">
        Kiállítói és galéria asszisztens
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="2" name="task[]">
      <label class="form-check-label">
        Ügyintéző, rendezvényszervező asszisztens
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="3" name="task[]">
      <label class="form-check-label">
        Program koordinátor
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="4" name="task[]">
      <label class="form-check-label">
        Építész, logisztika, raktár felügyelet
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="5" name="task[]">
      <label class="form-check-label">
        Hostess feladatok (vendégek kísérésre, VIP események felügyelete, vendégregisztráció)
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="6" name="task[]">
      <label class="form-check-label">
        Esemény előtti adminisztrációs feladatok (pl: információ gyűjtés, adatbázis tisztítás, szöveg ellenőrzés stb.)
      </label>
    </div>
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