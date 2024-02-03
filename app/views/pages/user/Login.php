<link rel="stylesheet" href="/public/css/user/login.css?v=<?= time() ?>">


<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
?>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card border-0 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="/public/assets/icons/logo.png" style="width: 185px;" alt="logo" class="my-3">
                </div>

                <form action="/user/login" method="POST" id="login" class="w-100">
                  <div class="text-center my-3">
                    <b class="text-center"><?= LOGIN["please"][$lang] ?? 'HIBA' ?></b>
                  </div>

                  <div class="form-outline mb-4">
                    <label for="email" class="form-label"><?= LOGIN["email"][$lang] ?? 'Email cim' ?></label>
                    <input type="email" class="form-control rounded" id="email" aria-describedby="emailHelp" name="email" placeholder="<?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?>">
                  </div>

                  <div class="form-outline mb-4">
                    <label for="password" class="form-label"><?= LOGIN["password"][$lang] ?? 'Jelszó' ?></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="<?= $langs["loginForm"]["password"][$lang] ?? 'Email cim' ?>">
                  </div>

                  <div class="text-center pt-1 mb-2 pb-1">
                    <button type="submit" class="btn secondary-btn"><?= LOGIN["loginBtn"][$lang] ?? 'Bejelentkezés' ?></button>
                    <p class="mt-3"><?= LOGIN["forgot"][$lang] ?? 'HIBA' ?></p>
                  </div>

                  <div class="d-flex align-items-center justify-content-center">
                    <p class="mb-0 me-2"><?= LOGIN["have"][$lang] ?? 'HIBA' ?></p>
                    <a href="/user/registration" class="btn btn-outline-dark"><?= LOGIN["create-btn"][$lang] ?? 'HIBA' ?></a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 bg-dark d-none d-lg-flex align-items-center">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4 text-uppercase"><?= LOGIN["description_title"][$lang] ?? 'HIBA' ?></h4>
                <p class="small mb-0">
                  <?= LOGIN["description_content"][$lang] ?? 'HIBA' ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>