<?php $volunteer = $params["volunteer"]; ?>


<div class="container vh-100">
  <div class="row">
    <div class="col-12 my-5">
      <a href="/admin/volunteers">Vissza az önkéntesekhez</a>
    </div>
    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/volunteers/update/<?= $volunteer["id"] ?>" method="POST">

        <h1>Önkéntes frissitése</h1>
        <hr class="mb-5">

        <div class="form-outline mb-4">
          <label class="form-label" for="name">Név</label>
          <input type="text" id="name" class="form-control" name="name" value="<?= $volunteer["name"] ?>" required />
        </div>

        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionHu">Rövid leirás</label>
          <textarea class="form-control" id="descriptionHu" rows="4" name="description" required><?= $volunteer["descriptionInHu"] ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionEn">Rövid leirás angolul</label>
          <textarea class="form-control" id="descriptionEn" rows="4" name="descriptionInEn" required><?= $volunteer["descriptionInEn"] ?></textarea>
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
    </div>
  </div>
</div>