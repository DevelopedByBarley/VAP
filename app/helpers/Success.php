<?php

function success()
{

  if (session_id() == '') {
    session_start();
  }

  $lang = $_COOKIE["lang"];

  if ($lang === 'Hu') {
    $_SESSION["success"] = [
      "title" => "Köszönjük a regisztrációdat!",
      "message" => "Az eseményre való regisztráció megtörtént! Az e-mail címére visszaigazoló levelet küldtünk!",
      "button_message" => "Vissza a főoldalra",
      "path" => "/",
    ];
    header("Location: /success");
    return;
  } elseif ($lang === 'En') {
    $_SESSION["success"] = [
      "title" => "Thank you for your registration!",
      "message" => "Registration for the event is complete! We have sent a confirmation email to your email address!",
      "button_message" => "Back to the homepage",
      "path" => "/"
    ];
    header("Location: /success");
    return;
  } else {
    $_SESSION["success"] = [
      "title" => "'hiba'!",
      "message" => "Az eseményre való regisztráció megtörtént! Az e-mail címére visszaigazoló levelet küldtünk!",
      "button_message" => "Vissza a főoldalra",
      "path" => "/",
    ];
    header("Location: /success");
    return;
  }
}
