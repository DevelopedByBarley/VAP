<div class="container">
  <div class="row">
    <div class="col-12 my-5">
      <a href="/admin/partners">Vissza a partnerekhez</a>
    </div>
    <div class="col-12">
      <form enctype="multipart/form-data" action="/admin/partners/new" method="POST" class="form">

        <h1>Partner hozzáadása</h1>
        <hr class="mb-5">

        <div class="form-outline mb-4">
          <label class="form-label" for="name"><b>Partner neve</b></label>
          <input type="text" id="name" class="form-control" name="name" required placeholder="Partner neve" value="<?= $prev["name"]  ?? '' ?>" />
        </div>

        <!-- Message input -->

        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionInHu"><b>Rövid leirás</b></label>
          <textarea class="form-control" id="descriptionInHu" rows="4" name="descriptionInHu" required placeholder="Partner rövid leirása"><?= $prev["descriptionInHu"]  ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="descriptionInEn"><b>Rövid leirás angolul</b></label>
          <textarea class="form-control" id="descriptionInEn" rows="4" name="descriptionInEn" required placeholder="Partner rövid leirása angolul"><?= $prev["descriptionInEn"]  ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="link"><b>Partner link</b></label>
          <input type="text" class="form-control" id="link" name="link" required placeholder="Partner link"><?= $prev["descriptionInEn"]  ?? '' ?></input>
        </div>
        <div class="form-outline mb-4">
          <div class="mb-3">
            <label for="formFile" class="form-label"><b>Logo feltöltése</b></label>
            <input class="form-control" type="file" id="formFile" name="p_image" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
      </form>
    </div>
  </div>
</div>