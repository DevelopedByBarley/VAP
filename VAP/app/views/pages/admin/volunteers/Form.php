<div class="container">
  <div class="row">

    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/volunteers/new" method="POST" class="mt-5">
        <h1>Önkéntes hozzáadása</h1>
        <hr class="mb-5">

        <div class="form-outline mb-4">
          <label class="form-label" for="name">Név</label>
          <input type="text" id="name" class="form-control" name="name" required placeholder="Önkéntes neve" value="<?= $prev["name"] ?? '' ?>" />
        </div>

        <!-- Message input -->

        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionHu">Rövid leirás</label>
          <textarea class="form-control" id="descriptionHu" rows="4" name="description" required placeholder="Önkéntes rövid leirása"><?= $prev["description"] ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionEn">Rövid leirás angolul</label>
          <textarea class="form-control" id="descriptionEn" rows="4" name="descriptionInEn" required placeholder="Önkéntes rövid leirása angolul"><?= $prev["descriptionInEn"] ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <div class="mb-3">
            <label for="formFile" class="form-label">Fénykép feltöltése</label>
            <input class="form-control" type="file" id="formFile" name="v_image" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
      </form>
    </div>
  </div>