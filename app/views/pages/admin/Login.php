<link rel="stylesheet" href="/public/css/admin_login_form.css?v=<?= time() ?>">

<div class="container vh-100 d-flex align-items-center justify-content-center flex-column">
  <div class="row w-100 d-flex align-items-center justify-content-center flex-column">
    <div class="col-12 col-lg-4 mb-5 text-center">
      <img src="/public/assets/icons/logo.png" style="width: 250px;" alt="">
    </div>
    <div class="col-12 col-lg-4">
      <form class=" p-5" id="admin-login-form" action="/admin/login" method="POST">
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
    </div>
    </form>
  </div>
</div>