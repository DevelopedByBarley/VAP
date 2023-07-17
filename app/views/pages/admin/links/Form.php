<form enctype="multipart/form-data" action="/admin/links/new" method="POST">

  <h1 class="text-center mb-5 display-4" style="margin-top: 100px;">Link hozzáadása</h1>

  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név</label>
    <input type="text" id="name" class="form-control" name="nameInHu" required />
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név angolul</label>
    <input type="text" id="name" class="form-control" name="nameInEn" required />
  </div>

  <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Link URL</label>
      <input class="form-control" type="text" id="formFile" name="link" required>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>