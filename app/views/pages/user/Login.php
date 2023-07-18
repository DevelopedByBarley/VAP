<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>
<?= $params["alertContent"] ?>

<form action="/user/login" method="POST" id="login">
  <h1 class="display-4 text-center">
    <?= $langs["loginForm"]["title"][$lang] ?? 'Bejelentkezés' ?>
  </h1>
  <div class="mb-3 mt-5">
    <label for="email" class="form-label"><?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?></label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="<?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?>">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label"><?= $langs["loginForm"]["password"][$lang] ?? 'Jelszó' ?></label>
    <input type="password" class="form-control" id="password" name="password" placeholder="<?= $langs["loginForm"]["password"][$lang] ?? 'Email cim' ?>">
  </div>
  <div class="text-center mt-5">
    <button type="submit" class="btn btn-primary"><?= $langs["loginForm"]["loginBtn"][$lang] ?? 'Bejelentkezés' ?></button>
  </div>
</form>