

<div class="login-wrapper d-flex align-items-center justify-content-center" style="min-height: 90vh;">
  <div class="container d-flex align-items-center justify-content-center rounded" style="min-height: 70vh">
    <div class="row w-100 d-flex align-items-center justify-content-center">

      <div class="col-12 col-lg-7 p-5 d-none d-lg-block">
        <div id="forgot-pw-image" style="background: url('/public/assets/images/new-pw.jpg') center center/cover; min-height: 70vh;"></div>
      </div>

      <div class="col-xs-12 col-lg-5 rounded">
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
      </div>
    </div>
  </div>
</div>