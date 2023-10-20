<?php
class Alert
{
  // SET ALERT
  public function set($message, $bg, $location)
  {

    if (session_id() == '') {
      session_start();
    }

    $_SESSION["alert"] = [
      "message" => $message,
      "bg" => $bg,
      "expires" => time() + 2
    ];

    header("Location: $location");
    exit;
  }
}
