<?php
  class LanguageService{
    public function language($body)
    {
      $expiration_date = time() + (7 * 24 * 60 * 60);
  
      $cookie_name = "lang";
      $cookie_value = $body["language"] ?? null;
  
      setcookie($cookie_name, $cookie_value, $expiration_date, "/");
  
      header("Location: /");
    }
    public function switch($lang)
    {
      $expiration_date = time() + (7 * 24 * 60 * 60);
  
      $cookie_name = "lang";
      $cookie_value = $lang ?? null;
  
      setcookie($cookie_name, $cookie_value, $expiration_date, "/");
  
      header("Location: /");
    }
  }