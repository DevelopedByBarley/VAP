<?php
$alert = $_SESSION["alert"] ?? null;
?>

<link rel="stylesheet" href="/public/css/components/alert.css">

<?php if (isset($alert)) : ?>
  <div id="toast-modal" class="text-center toast p-2 align-items-center text-white bg-<?= $alert["bg"] ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <b style="font-size: .9rem;"><?php echo $alert["message"]; ?></b>
      </div>
    </div>
  </div>
  <script>
    const toast = document.querySelector("#toast-modal");
    setTimeout(() => {
      toast.style.display = "none";
    }, 3000)
  </script>
<?php endif; ?>


<?php
if (isset($alert)) {
  // Az alert session lejárt, töröljük
  unset($_SESSION['alert']);
}
?>