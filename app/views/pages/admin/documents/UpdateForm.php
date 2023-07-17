<?php $document = $params["document"] ?>

<form enctype="multipart/form-data" action="/admin/document/update/<?= $document["id"] ?>" method="POST">

  <h1 class="text-center mb-5 display-4" style="margin-top: 100px;">Partner frissitése</h1>

  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név</label>
    <input type="text" id="name" class="form-control" name="nameInHu" required value="<?= $document["nameInHu"] ?? '' ?> " />
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név angolul</label>
    <input type="text" id="name" class="form-control" name="nameInEn" required value="<?= $document["nameInEn"] ?? '' ?> " />
  </div>

  <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Fájl feltöltése</label>
      <input class="form-control" type="file" id="formFile" name="file">
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>