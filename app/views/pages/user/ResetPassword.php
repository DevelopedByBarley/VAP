
<?php echo $params["alertContent"]; ?>


<form id="password-reset-form" action="/user/password-reset" method="POST">
  <h1 class="text-center mb-5 mt-5">Jelszó megváltoztatása</h1>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label required">Régi jelszó</label>
    <input type="password" class="form-control" name="old_password" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label required">Új jelszó</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="new_password" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label required">Új jelszó újra</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="confirm_password" required>
  </div>

  <div class="text-center mt-5">
    <button type="submit" class="btn btn-outline-danger">Jelszó megváltoztatása</button>
  </div>
</form>