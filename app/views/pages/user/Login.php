<link rel="stylesheet" href="/public/css/user/login.css?v=<?= time() ?>">


<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$langs = LANGS;
?>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="/public/assets/icons/logo.png" style="width: 185px;" alt="logo" class="my-5">
                  <h4 class="mt-1 my-5 pb-1">Welcome to the VAP Team</h4>
                </div>

                <form action="/user/login" method="POST" id="login" class="w-100">
                  <p>Please login to your account</p>

                  <div class="form-outline mb-4">
                    <label for="email" class="form-label"><?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?></label>
                    <input type="email" class="form-control rounded" id="email" aria-describedby="emailHelp" name="email" placeholder="<?= $langs["loginForm"]["email"][$lang] ?? 'Email cim' ?>">
                  </div>

                  <div class="form-outline mb-4">
                    <label for="password" class="form-label"><?= $langs["loginForm"]["password"][$lang] ?? 'Jelszó' ?></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="<?= $langs["loginForm"]["password"][$lang] ?? 'Email cim' ?>">
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button type="submit" class="btn secondary-btn"><?= $langs["loginForm"]["loginBtn"][$lang] ?? 'Bejelentkezés' ?></button>
                    <p class="mt-3">Forgot <a href="/user/forgot-pw">Password?</a></p>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a href="/user/registration" class="btn btn-outline-primary">Create new</a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 bg-dark d-none d-lg-flex align-items-center">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">We are more than just a company</h4>
                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                  exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>