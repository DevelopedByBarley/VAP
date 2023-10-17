<?php $link = $params["link"] ?>
<div class="container">
  <div class="row">
    <div class="col-12 my-5">
      <a href="/admin/links">Vissza a linkekhez</a>
    </div>
    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/links/update/<?= $link["id"] ?>" method="POST" class="form">

        <h1>Link frissítése</h1>
        <hr class="mb-5">

        <div class="form-outline mb-4">
          <label class="form-label" for="name">Név</label>
          <input type="text" id="name" class="form-control" name="nameInHu" required value="<?= $link["nameInHu"] ?? '' ?>" />
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="name">Név angolul</label>
          <input type="text" id="name" class="form-control" name="nameInEn" required value="<?= $link["nameInEn"] ?? '' ?>" />
        </div>

        <div class="form-outline mb-4">
          <div class="mb-3">
            <label for="formFile" class="form-label">Link URL</label>
            <input class="form-control" type="text" id="formFile" name="link" required value="<?= $link["link"] ?? '' ?>">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
      </form>
    </div>
  </div>
</div>