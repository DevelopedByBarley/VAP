<?php
$alert = $_COOKIE["alert_message"] ?? null;
$bg = $_COOKIE["alert_bg"] ?? null;


?>

<?php if (isset($alert)) : ?>
  <div id="toast-modal" class="toast align-items-center text-white bg-<?= $bg ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; bottom: 20px; right: 50%; z-index: 100; transform: translate(50%)">
    <div class="d-flex">
      <div class="toast-body">
        <b><?php echo $alert; ?></b>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<script>
  const toast = document.querySelector("#toast-modal");
  setTimeout(() => {
    toast.style.display = "none";
  }, 5000)
</script>

