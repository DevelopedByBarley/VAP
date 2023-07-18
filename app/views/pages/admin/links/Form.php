<form enctype="multipart/form-data" action="/admin/links/new" method="POST" class="form">

  <h1 class="display-5">Link hozzáadása</h1>
  <hr class="mb-5">
  
  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név</label>
    <input type="text" id="name" class="form-control" name="nameInHu" required placeholder="Link neve magyarul"/>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="name">Név angolul</label>
    <input type="text" id="name" class="form-control" name="nameInEn" required placeholder="Link neve angolul"/>
  </div>

  <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Link URL</label>
      <input class="form-control" type="text" id="formFile" name="link" required placeholder="URL">
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>