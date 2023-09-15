<?php
$event = $params["event"];
?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center vh-100">
    <div class="col-xs-12">
      <form action="/admin/event/email/send/<?= $event["eventId"] ?>" method="POST">
        <section class="shadow p-5 mb-5">
          <h3>Email Magyarul</h3>
          <textarea rows="30" class="editor mb-5" name="mail-body-Hu" style="height: 200px;"></textarea>
        </section>
        <section class="shadow p-5">
          <h3 class="mt-5">Email Angolul</h3>
          <textarea rows="30" class="editor" name="mail-body-En" style="height: 200px;"></textarea>
        </section>

        <div class="text-center">
          <button type="submit" class="btn btn-outline-primary mt-5">Emailek elküldése</button>

        </div>
      </form>
    </div>
  </div>
</div>