<?php
$alert = $_SESSION["alert"] ?? null;
?>

<?php if (isset($alert)) : ?>
  <div id="toast-modal" class="text-center toast align-items-center text-white bg-<?= $alert["bg"] ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; bottom: 20px; right: 50%; z-index: 100; transform: translate(50%)">
    <div class="d-flex">
      <div class="toast-body">
        <b><?php echo $alert["message"]; ?></b>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  <script>
    const toast = document.querySelector("#toast-modal");
    setTimeout(() => {
      toast.style.display = "none";
    }, 2000)
  </script>
<?php endif; ?>


<?php
if (isset($alert)) {
  // Az alert session lejárt, töröljük
  unset($_SESSION['alert']);
}
?>
