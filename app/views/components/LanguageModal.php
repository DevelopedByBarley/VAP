<link rel="stylesheet" href="/public/css/components/language_modal.css?v=<?php echo time() ?>">

<div id="lang-modal-container">
  <div id="language-modal">
    <form action="/language" method="POST" id="language-form" class="d-flex align-items-center justify-content-center flex-column">
      <div class="language-form-title text-center mb-3">
        <h1>Nyelv kiválasztása</h1>
      </div>
      <div>
        <input type="radio" class="btn-check" name="language" id="en" value="Hu" autocomplete="off" checked>
        <label class="btn btn-outline-success m-2" for="en">
          <img src="/public/assets/icons/hu.png" class="lang-icon" />
        </label>
        <input type="radio" class="btn-check" name="language" id="hu" value="En" autocomplete="off">
        <label class="btn btn-outline-danger m-2" for="hu">
          <img src="/public/assets/icons/en.png" class="lang-icon" />
        </label>
      </div>
      <div>
        <button type="submit" class="btn btn-primary mt-5">
          Kiválaszt
        </button>
      </div>
    </form>
  </div>
</div>