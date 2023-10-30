<link rel="stylesheet" href="/public/css/user/documents.css">

<?php
$user = $params["user"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;

?>
<div class="d-flex align-items-center flex-column justify-content-center vh-100">

  <div id="user-documents" class="container">
    <div class="row">
      <div class="col-12">
        <form action="/user/documents/new" method="POST" enctype="multipart/form-data" class="head">
          <div class="document mt-2">
            <h1 class="text-center text-lg-start mt-2 mb-3 text-uppercase"><?= NEW_DOCUMENT_FORM["add_document"][$lang] ?? 'HIBA' ?></h1>
            <p class="text-center text-lg-start"><?= NEW_DOCUMENT_FORM["content"][$lang] ?? 'HIBA' ?></p>
            <hr class="mb-4 text-light">
            <select class="form-select mb-3" aria-label="Default select example" required name=typeOfDocument>
              <?php foreach (DOCUMENTS["types"] as $index => $typeOfDocument) : ?>
                <option value="<?= $index ?>">
                  <?= $typeOfDocument[$lang] ?>
                </option>
              <?php endforeach ?>
            </select>
            <div class="mb-3" class="document">
              <label for="document" class="mb-2">
                <b><?= NEW_DOCUMENT_FORM["upload"][$lang] ?? 'HIBA' ?></b>
              </label>
              <input class="form-control" type="file" name="document" id="documents" required />
            </div>
            <div class="text-center">
              <button type="submit" class="mt-3 btn btn-primary text-light"><?= UPLOADED_DOCUMENTS["add_document"][$lang] ?? 'HIBA' ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>