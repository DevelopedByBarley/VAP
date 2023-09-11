<?php
$event = $params["event"];
?>

<form action="/admin/event/email/send/<?= $event["eventId"] ?>" method="POST">
  <h3>Email Magyarul</h3>
  <textarea rows="30" class="editor" name="mail-body-Hu" style="height: 200px;"></textarea>
  <h3 class="mt-5">Email Angolul</h3>
  <textarea rows="30" class="editor" name="mail-body-En" style="height: 200px;"></textarea>

  <div class="text-center">
    <button type="submit" class="btn btn-outline-primary mt-5">Elküld</button>

  </div>
</form>