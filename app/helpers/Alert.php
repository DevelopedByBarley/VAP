<?php
class Alert
{
  // SET ALERT
  public function set($message, $messageInEng = null, $messageInSp = null, $bg, $location)
  {

    if (session_id() == '') {
      session_start();
    }

    $lang = $_COOKIE["lang"] ?? null;

    if ($lang === "Hu") {
      $_SESSION["alert"] = [
        "message" => $message,
        "bg" => $bg,
        "expires" => time() + 2
      ];

      header("Location: $location");
      exit;

    } else if ($lang === "En") {
      $_SESSION["alert"] = [
        "message" => $messageInEng,
        "bg" => $bg,
        "expires" => time() + 2
      ];
      header("Location: $location");
      exit;
      
    }
  }
}
