<form enctype="multipart/form-data" action="/admin/document/new" method="POST" class="form">

  <h1>Dokumentum hozzáadása</h1>
  <hr class="mb-5">

  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név</label>
    <input type="text" id="name" class="form-control" name="nameInHu" required placeholder="Dokumentum neve magyarul"/>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név angolul</label>
    <input type="text" id="name" class="form-control" name="nameInEn" required placeholder="Dokumentum neve angolul"/>
  </div>

  <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Fájl feltöltése</label>
      <input class="form-control" type="file" id="formFile" name="document" required>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>