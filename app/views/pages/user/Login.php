<link rel="stylesheet" href="/public/css/user/login.css?v=<?= time() ?>">


<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>
<?= $params["alertContent"] ?>


<div class="login-wrapper d-flex align-items-center justify-content-center pr-color" style="min-height: 90vh;">
  <div class="container d-flex align-items-center justify-content-center rounded" style="min-height: 70vh; background: white;" id="user-login-con">
    <div class="row w-100 d-flex align-items-center justify-content-center">
      <div class="col-xs-12 col-lg-5 d-flex align-items-center justify-content-center" id="login-col">
        <img src="/public/assets/icons/login.jpg" id="login-logo" />
      </div>
      <div class="col-xs-12 col-lg-5 rounded">
        <form action="/user/login" method="POST" id="login" class="w-100">
          <h1 class="text-center">
            <?= $langs["loginForm"]["title"][$lang] ?? 'Bejelentkezés' ?>
          </h1>
          <div class="mb-3 mt-5">
            <label for="email" class="form-label"><?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?></label>
            <input type="email" class="form-control rounded" id="email" aria-describedby="emailHelp" name="email" placeholder="<?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?>">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label"><?= $langs["loginForm"]["password"][$lang] ?? 'Jelszó' ?></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="<?= $langs["loginForm"]["password"][$lang] ?? 'Email cim' ?>">
          </div>
          <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary"><?= $langs["loginForm"]["loginBtn"][$lang] ?? 'Bejelentkezés' ?></button>
            <p class="mt-3">Forgot <a href="/user/forgot-pw">Password?</a></p>
          </div>
          <div class="mt-5 text-center">
            <a href="/user/registration" class="text-info" style="text-decoration: none;">Create your account <i class="bi bi-arrow-right"></i></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>