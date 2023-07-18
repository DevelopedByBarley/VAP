<?php $alert = $_SESSION["alert"] ?? null;
$bg = $alert["bg"] ?? null; 
$message = $alert["message"] ?? null  ; 
?>


<?php if (isset($alert)) : ?>
  <div id="alert-modal" class="alert text-light text-center" style="position: fixed; width: 100%; top: 0; left: 0; background: <?= $bg ?>">
    <b><?php echo $message; ?></b>
  </div>
<?php endif; ?>




<script>
  const alert = document.querySelector("#alert-modal");
  setTimeout(() => {
    alert.style.display = "none";
  }, 2000)

  console.log(alert);
</script>