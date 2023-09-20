<link rel="stylesheet" href="/public/css/user/documents.css">

<?php
$user = $params["user"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>
<div class="d-flex align-items-center flex-column justify-content-center vh-100">

  <div id="user-documents" class="shadow bg-light">
    <form action="/user/documents/new" method="POST" enctype="multipart/form-data" class="head">
      <div class="document border p-5 mt-2">
        <h1 class="text-center mt-2 mb-3 ">Dokumentum hozzáadása</h1>
        <hr class="mb-4 text-light">
        <select class="form-select mb-3" aria-label="Default select example" required name=typeOfDocument>
          <?php foreach (UPLOAD_DOCUMENTS["types"] as $index => $typeOfDocument) : ?>
            <option value="<?= $index ?>">
              <?= $typeOfDocument[$lang] ?>
            </option>
          <?php endforeach ?>
        </select>
        <div class="mb-3" class="document">
          <input class="form-control" type="file" name="document" id="documents" required />
        </div>
        <div class="text-center">
          <button type="submit" class="mt-3 btn btn-primary text-light">Hozzáadás</button>
        </div>
      </div>
    </form>
  </div>
</div>