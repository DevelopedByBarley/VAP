<?php
$question = $params["question"];

?>



<form action="/admin/questions/update/<?= $question["q_id"] ?>" method="POST">

  <h1 class="text-center mb-5 display-4" style="margin-top: 100px;">Gyakori kérdés hozzáadása</h1>

  <!-- Message input -->

  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Kérdés</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="questionInHu" required><?= $question["questionInHu"] ?? '' ?></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Kérdés angolul</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="questionInEn" required><?= $question["questionInEn"] ?? '' ?></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Válasz</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="answerInHu" required><?= $question["answerInHu"] ?? '' ?></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Válasz angolul</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="answerInEn" required><?= $question["answerInEn"] ?? '' ?></textarea>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Frissit</button>
</form>