<form enctype="multipart/form-data" action="/admin/volunteers/new" method="POST">

  <h1 class="text-center mb-5 display-4" style="margin-top: 100px;">Önkéntes hozzáadása</h1>

  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név</label>
    <input type="text" id="name" class="form-control" name="name" required />
  </div>

  <!-- Message input -->

  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Rövid leirás</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="description" required></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Rövid leirás angolul</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="descriptionInEn" required></textarea>
  </div>
  <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Fénykép feltöltése</label>
      <input class="form-control" type="file" id="formFile" name="v_image" required>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>