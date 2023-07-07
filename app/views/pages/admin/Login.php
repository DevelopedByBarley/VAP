<form class="border p-5" id="admin-login-form" action="/administrator/login" method="POST">
  <div class="mb-3">
    <label class="form-label">Név</label>
    <input type="text" class="form-control" name="name" placeholder="Név" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Jelszó</label>
    <input type="password" class="form-control" name="password" placeholder="Jelszó" required>
  </div>
  <div class="text-center mt-5">
    <button type="submit" id="login-admin" class="btn btn-outline-dark">Bejelentkezés</button>
  </div>
</form>