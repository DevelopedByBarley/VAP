<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$email = $params["emailByToken"] ?? null;
$token = $params["token"] ?? null;

var_dump($token);
var_dump($email);
?>




<div class="login-wrapper d-flex align-items-center justify-content-center" style="min-height: 90vh;">
  <div class="container d-flex align-items-center justify-content-center rounded" style="min-height: 700px">
    <div class="row w-100 d-flex align-items-center justify-content-center">

      <div class="col-12 col-lg-7 p-5 d-none d-lg-block">
        <div id="forgot-pw-image" style="background: url('/public/assets/images/new-pw.jpg') center center/cover; min-height: 700px;"></div>
      </div>

      <div class="col-xs-12 col-lg-5 rounded">
        <form id="password-reset-form" action="/user/set-new-pw" method="POST">
          <h1 class="text-center mb-5 mt-5">
            <?= CHANGE_PW["title"][$lang] ?? 'HIBA' ?>
          </h1>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label required"><?= CHANGE_PW["new_pw"][$lang] ?? 'HIBA' ?></label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" required placeholder="<?= CHANGE_PW["new_pw"][$lang] ?? 'HIBA' ?>">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label required"><?= CHANGE_PW["new_pw_again"][$lang] ?? 'HIBA' ?></label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password-repeat" required placeholder="<?= CHANGE_PW["new_pw_again"][$lang] ?? 'HIBA' ?>">
          </div>

          <div class="hiddens">
            <input type="hidden" id="email" name="email" value="<?= $email ?>">
            <input type="hidden" id="token" name="token" value="<?= $token ?>">
          </div>

          <div class="text-center mt-5">
            <button type="submit" class="btn btn-outline-danger">Jelszó megváltoztatása</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>