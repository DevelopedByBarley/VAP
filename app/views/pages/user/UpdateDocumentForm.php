<?php
$user = $params["user"];
$document = $params["document"];
$subscriptions = $params["subscriptions"] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;

?>

<div id="user-documents">
  <form action="/user/documents/update/<?= $document["id"] ?>" method="POST" enctype="multipart/form-data" class="head">
    <div class="document border p-5 mt-2">
      <h1 class="text-center mt-2 mb-3 ">Dokumentum frissitése</h1>
      <hr class="mb-4 text-light">
      <select class="form-select mb-3" aria-label="Default select example" required name=typeOfDocument>
        <?php foreach (UPLOAD_DOCUMENTS["types"] as $index => $typeOfDocument) : ?>

          <option value="<?= $index ?>" <?php echo (int)$document["type"] === (int)$index ? 'selected' : '' ?>>
            <?= $typeOfDocument[$lang] ?>
          </option>
        <?php endforeach ?>
      </select>
      <div class="mb-3" class="document">
        <input class="form-control" type="file" name="document" id="documents" />
      </div>
      <div class="text-center">
        <button type="submit" class="mt-3 btn btn-warning text-light">Frissités</button>
      </div>
    </div>
  </form>
</div>