<?php
$user = $params["user"] ?? null;
$lang = $user["lang"];

?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center vh-100">
    <div class="col-xs-12">
      <h2 class="mt-5">E-mail küldése</h2>
      <p>
        Erről az oldalról e-mail-t küldhet <b><?= $user["name"] ?>(<?= $user["lang"] ?>)</b> nevű felhasználónak aki létrehozott profilt ezen a weboldalon !
        <br>
        Az email nyelvét mindíg attól függően válassza hogy a név melletti zárójelben milyen nyelvet lát, ugyanis a user ilyen nyelven töltötte ki a regisztrációját .
      </p>
      <form action="/admin/user/email/send/<?= $user["id"] ?>" method="POST" class="row">

        <section class="p-1 p-sm-5 bg-dark col-12 mb-5">
          <h3 class="text-light mt-3 mb-5">Email</h3>
          <textarea class="editor mb-5" name="mail-body"></textarea>
        </section>

        <div class="text-center">
          <button type="submit" class="btn btn-outline-primary mt-5">Emailek elküldése</button>

        </div>
      </form>
    </div>
  </div>
</div>
</div>