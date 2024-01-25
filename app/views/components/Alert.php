<?php
$alert = $_SESSION["alert"] ?? null;


?>

<?php if (isset($alert)) : ?>
  <div id="toast-modal" class="text-center toast p-2 align-items-center text-white bg-<?= $alert["bg"] ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; bottom: 20px; right: 40%; z-index: 100;">
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

  <style>
    #toast-modal {
      animation-name: alert;
      animation-duration: 3s;
      animation-timing-function: ease-in-out;

    }

    @keyframes alert {
      0% {
        transform: translateY(150%);
        opacity: 0;
      }

      10% {
        transform: translateY(0%);

      }

      15% {
        opacity: 1;
      }

      90% {
        opacity: 1;
      }

      95% {
        transform: translateY(0%);
      }

      100% {
        transform: translateY(150%);
        opacity: 0;
      }
    }
  </style>
<?php endif; ?>


<?php
if (isset($alert)) {
  // Az alert session lejárt, töröljük
  unset($_SESSION['alert']);
}
?>