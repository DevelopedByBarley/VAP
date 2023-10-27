<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>


<div class="login-wrapper d-flex align-items-center justify-content-center" style="min-height: 90vh;">
  <div class="container d-flex align-items-center justify-content-center rounded" style="min-height: 70vh">
    <div class="row w-100 d-flex align-items-center justify-content-center">

      <div class="col-12 col-lg-7 p-5 sm-none">
        <div id="forgot-pw-image" style="background: url('/public/assets/images/new-pw.jpg') center center/cover; min-height: 600px;"></div>
      </div>

      <div class="col-xs-12 col-lg-5 rounded">
        <form action="/user/set-new-pw" method="POST" id="login" class="w-100">
          <h1 class="text-center">
            <?= 'Új jelszó beállitása' ?>
          </h1>
          <div class="mb-3 mt-5">
            <label for="password" class="form-label">Új Jelszó</label>
            <input type="password" class="form-control rounded" id="password" aria-describedby="pw" name="password" placeholder="Jelszó" required>
          </div>
          <div class="mb-3 mt-3">
            <label for="password-repeat" class="form-label">Új Jelszó újra</label>
            <input type="password" class="form-control rounded" id="password-repeat" aria-describedby="pw" name="password-repeat" placeholder="Jelszó újra" required>
          </div>

          <input type="hidden" name="email" value="<?= $params["emailByToken"] ?>">
          <input type="hidden" name="token" value="<?= $params["token"] ?>">

          <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Új jelszó beállitása</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>