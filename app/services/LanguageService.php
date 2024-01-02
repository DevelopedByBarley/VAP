<?php

class LanguageService
{
  public function language()
  {

    $expiration_date = time() + (7 * 24 * 60 * 60);
    $ret = "";


    $browser_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

    // Az első preferált nyelv kinyerése a listából
    $preferred_languages = explode(',', $browser_language);
    $language = strtolower(trim(explode(';', $preferred_languages[0])[0]));

    
    if ($language === "hu-hu") {
      $ret = "Hu";
    } elseif($language === "es") {
      $ret = "Sp";
    } else {
      $ret = "En";
    }
    
    

    $cookie_name = "lang";


    setcookie($cookie_name, $ret, $expiration_date, "/");

  }

  // SWITCH LANGUAGE

  public function switch($lang)
  {
    $expiration_date = time() + (7 * 24 * 60 * 60);
    $referer = $_SERVER["HTTP_REFERER"];

    $cookie_name = "lang";
    $cookie_value = $lang ?? null;

    setcookie($cookie_name, $cookie_value, $expiration_date, "/");

    header("Location: $referer");
  }
}
