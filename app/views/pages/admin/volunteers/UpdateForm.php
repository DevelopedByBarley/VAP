<?php $volunteer = $params["volunteer"]; ?>


<form enctype="multipart/form-data" action="/admin/volunteers/update/<?= $volunteer["id"] ?>" method="POST" class="form">

  <h1 class="display-5">Önkéntes frissitése</h1>
  <hr class="mb-5">

  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név</label>
    <input type="text" id="name" class="form-control" name="name" value="<?= $volunteer["name"] ?>" required />
  </div>

  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Rövid leirás</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="description" required><?= $volunteer["descriptionInHu"] ?></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Rövid leirás angolul</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="descriptionInEn" required><?= $volunteer["descriptionInEn"] ?></textarea>
  </div>
  <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Fénykép feltöltése</label>
      <input class="form-control" type="file" id="formFile" name="v_image">
    </div>
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-warning text-light btn-block mb-4">Önkéntes frissitése</button>
  </div>
</form>