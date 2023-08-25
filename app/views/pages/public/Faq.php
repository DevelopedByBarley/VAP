<?php
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : null;
$questions = $params["questions"];

?>

<h1 class="display-4 text-center mt-5 mb-5"><?= CONTENT["faq"][$lang] ?? '' ?></h1>
<div class="container">
  <div class="row mt-5" id="faq">
    <div class="col-xs-12">
      <div class="accordion mt-5 mb-5" id="questionAccordion">
        <?php foreach ($questions as $index => $question) : ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $question["q_id"] ?>" aria-expanded="false" aria-controls="collapseTwo">
                <?= $question[languageSwitcher("question")] ?>
              </button>
            </h2>
            <div id="collapse<?= $question["q_id"] ?>" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong><?= $question[languageSwitcher("answer")] ?></strong>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>