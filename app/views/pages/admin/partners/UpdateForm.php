<?php $partner = $params["partner"]; ?>

<div class="container">
  <div class="row">
    <div class="col-12 my-5">
      <a href="/admin/partners">Vissza a partnerekhez</a>
    </div>

    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/partners/update/<?= $partner["id"] ?>" method="POST" class="form">

        <h1>Partner frissitése</h1>
        <hr class="mb-5">

        <div class="form-outline mb-4">
          <label class="form-label" for="name">Név</label>
          <input type="text" id="name" class="form-control" name="name" value="<?= $partner["name"] ?>" required />
        </div>

        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionInHu">Rövid leirás</label>
          <textarea class="form-control" id="descriptionInHu" rows="4" name="descriptionInHu" required><?= $partner["descriptionInHu"] ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionInEn">Rövid leirás angolul</label>
          <textarea class="form-control" id="descriptionInEn" rows="4" name="descriptionInEn" required><?= $partner["descriptionInEn"] ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionInEn">Partner link</label>
          <input type="text" class="form-control" id="link" name="link" required placeholder="Partner link" value="<?= $partner["link"]  ?? '' ?>"/>
        </div>
        <div class="form-outline mb-4">
          <div class="mb-3">
            <label for="formFile" class="form-label">Fénykép feltöltése</label>
            <input class="form-control" type="file" id="formFile" name="p_image">
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-warning text-light btn-block mb-4">Önkéntes frissitése</button>
        </div>
      </form>
    </div>
  </div>
</div>