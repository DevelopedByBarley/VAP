<?php
$question = $params["question"];

?>

<div class="container">
  <div class="row">
    <div class="col-12">
      <form action="/admin/questions/update/<?= $question["q_id"] ?>" method="POST" class="form">

        <h1>Gyakori kérdés szerkesztése</h1>
        <hr class="mb-5">

        <!-- Message input -->

        <div class="form-outline mb-4">
          <label class="form-label" for="questionInHu">Kérdés</label>
          <textarea class="form-control" id="questionInHu" rows="4" name="questionInHu" required><?= $question["questionInHu"] ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="questionInEn">Kérdés angolul</label>
          <textarea class="form-control" id="questionInEn" rows="4" name="questionInEn" required><?= $question["questionInEn"] ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="answerInHu">Válasz</label>
          <textarea class="form-control" id="answerInHu" rows="4" name="answerInHu" required><?= $question["answerInHu"] ?? '' ?></textarea>
        </div>
        <div class="form-outline mb-4">
          <label class="form-label" for="answerInEn">Válasz angolul</label>
          <textarea class="form-control" id="answerInEn" rows="4" name="answerInEn" required><?= $question["answerInEn"] ?? '' ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-4">Frissit</button>
      </form>
    </div>
  </div>
</div>