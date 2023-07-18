<form action="/admin/questions/new" method="POST" class="form">

  <h1 class="display-5">Gyakori kérdés hozzáadása</h1>
  <hr class="mb-5">

  <!-- Message input -->

  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Kérdés</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="questionInHu" required placeholder="Kérdés magyarul"></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Kérdés angolul</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="questionInEn" required placeholder="Kérdés angolul"></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Válasz</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="answerInHu" required placeholder="Válasz magyarul"></textarea>
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="form4Example3">Válasz angolul</label>
    <textarea class="form-control" id="form4Example3" rows="4" name="answerInEn" required placeholder="Válasz angolul"></textarea>
  </div>

  <button type="submit" class="btn btn-primary btn-block mb-4">Hozzáad</button>
</form>