<?php
$event = $params["event"];
?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center vh-100">
    <div class="col-xs-12">
      <h2 class="mt-5">E-mail küldése</h2>
      <p>Erről az oldalról e-mail-t küldhet az összes eddig erre az eseményre regisztrált felhasználónak Angolul és Magyarul, attól függően milyen nyelven töltötték ki a jelentkezést </p>
      <hr class="mb-5">  
      <form action=" /admin/event/email/send/<?= $event["eventId"] ?>" method="POST" class="row">

      <section class="p-1 p-sm-5 bg-dark col-12 mb-5">
        <h3 class="text-light mt-3 mb-5">Email Magyarul</h3>
        <textarea class="editor mb-5" name="mail-body-Hu"></textarea>
      </section>

      <section class="p-1 p-sm-5 bg-dark col-12">
        <h3 class="mt-3 mb-5 text-light">Email Angolul</h3>
        <textarea class="editor" name="mail-body-En"></textarea>
      </section>

      <div class="text-center">
        <button type="submit" class="btn btn-outline-primary mt-5">Emailek elküldése</button>

      </div>
      </form>
    </div>
  </div>
</div>