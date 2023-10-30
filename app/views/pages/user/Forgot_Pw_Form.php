<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
?>


<div class="login-wrapper d-flex align-items-center justify-content-center" style="min-height: 90vh;">
  <div class="container d-flex align-items-center justify-content-center rounded" style="min-height: 70vh">
    <div class="row w-100 d-flex align-items-center justify-content-center">

      <div class="col-12 col-lg-7 p-5 d-none d-lg-block">
        <div id="forgot-pw-image" style="background: url('/public/assets/images/forgot.jpg') center center/cover; min-height: 600px;"></div>
      </div>

      <div class="col-xs-12 col-lg-5 rounded">
        <form action="/user/pw/new" method="POST" id="login" class="w-100">
          <h1 class="text-center text-uppercase">
            <?= FORGOT_PW["title"][$lang] ?? 'HIBA' ?>
          </h1>
          <div class="mb-3 mt-5">
            <label for="email" class="form-label"> <?= FORGOT_PW["email"][$lang] ?? 'HIBA' ?></label>
            <input type="email" class="form-control rounded" id="email" aria-describedby="emailHelp" name="email" placeholder="<?= FORGOT_PW["email"][$lang] ?? 'HIBA' ?>">
          </div>

          <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary"><?= FORGOT_PW["pw_req"][$lang] ?? 'HIBA' ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>